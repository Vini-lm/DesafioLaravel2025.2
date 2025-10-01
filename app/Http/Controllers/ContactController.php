<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{

    public function index()
    {
        return view('contact');
    }


    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);
        
      
        Mail::to(env('MAIL_CONTACT_TO', 'admin@exemplo.com'))
            
            ->send(new Contact($validated)); 

      
        return Redirect::back()->with('status', 'mensagem enviada com sucesso!');
    }
}
