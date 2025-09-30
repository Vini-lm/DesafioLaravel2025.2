<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produto;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PagSeguroController extends Controller
{
    public function createCheckout(Request $request)
    {

        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::findOrFail($request->produto_id);
        $quantidade = (int) $request->quantidade;

        if ($quantidade > $produto->quantidade) {
            return back()->withInput()->withErrors(['quantidade' => 'A quantidade solicitada não está disponível em estoque.']);
        }


        $url = config('services.pagseguro.checkout_url');
        $token = config('services.pagseguro.token');

        //$product = json_decode($request->produto,true);
        
        $items = [
            [
                'id' =>  $produto->id, 
                'name' => $produto->nome,
                'unit_amount' => $produto->preco * 100, 
                'quantity' => $quantidade,
            ]
        ];


        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json'
        ])->withoutVerifying()->post($url,[
            'reference_id' => uniqid(),
            'items' => $items,
        ]);


        if($response->successful())
        {
            Order::create([
                'reference_id' => $response['reference_id'],
                'status' => 1
            ]);
            $pay_link = data_get($response->json(), 'links.1.href');
            return redirect()->away($pay_link);
        }

        return redirect('erro-pagamento');

    }
}
