<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Venda; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ProdutoController extends Controller
{
   
    public function finalizarCompra(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);
        
        $produto = Produto::findOrFail($id);
        $quantidadeComprada = $request->input('quantidade');
        $comprador = Auth::user();

        if ($quantidadeComprada > $produto->quantidade) {
            return back()->with('error', 'Quantidade solicitada maior que o estoque disponível.');
        }

        
        DB::transaction(function () use ($produto, $quantidadeComprada, $comprador) {
           
            $produto->quantidade -= $quantidadeComprada;
            $produto->save();

            
            Venda::create([
                'produto_id' => $produto->id,
                'comprador_id' => $comprador->id,
                'vendedor_id' => $produto->vendedor_id,
                'quantidade' => $quantidadeComprada,
                'valor_unitario' => $produto->preco,
                'valor_total' => $produto->preco * $quantidadeComprada,
            ]);
        });

        return redirect()->route('home_page')->with('success', 'Compra realizada com sucesso!');
    }


  
    
public function manage()
{
    $user = Auth::user();
    $chart = null; 

    if ($user->isAdmin) {
        
        $produtos = Produto::with('vendedor')->latest()->get();

        
        $chart_options = [
            'chart_title' => 'Produtos cadastrados por mês',
            'model' => Produto::class,
            'chart_type' => 'bar',
            'report_type' => 'group_by_date',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color' => '0, 122, 255',
            'last_days' => 365,
        ];

        
        $chart = new LaravelChart($chart_options);

    } else {
        $produtos = Produto::where('vendedor_id', $user->id)->latest()->get();
    }

    return view('produtos.manage', compact('produtos', 'chart'));
}

    public function index()
    {
        $produtos = Produto::all();
        return view('home.home_page', compact('produtos'));
    }

    public function show($id)
    {
        $produto = Produto::with('vendedor')->findOrFail($id);
        return view('produtos.pvi_product', compact('produto'));
    }

    public function comprar($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.compra', compact('produto'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'required|string',
            'categoria' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['vendedor_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produtos', 'public');
        }

        Produto::create($data);

        return redirect()->route('admin.produtos.manage')->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        if (!Auth::user()->isAdmin && Auth::denies('update', $produto)) {
            abort(403);
        }
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        if (!Auth::user()->isAdmin && Auth::denies('update', $produto)) {
            abort(403);
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'desc' => 'required|string',
            'categoria' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produtos', 'public');
        }

        $produto->update($data);

        return redirect()->route('admin.produtos.manage')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        if (!Auth::user()->isAdmin && Auth::denies('delete', $produto)) {
            abort(403);
        }

        $produto->delete();

        return redirect()->route('admin.produtos.manage')->with('success', 'Produto excluído com sucesso!');
    }
}
