<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class HpController extends Controller
{
    

    public function index(){

        $produtos = Produto::all();
        return view('home_page', compact('produtos'));
    }
}
