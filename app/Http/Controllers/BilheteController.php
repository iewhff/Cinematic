<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BilheteController extends Controller
{

    public function create()
    {
        $title = 'Comprar Bilhete';
        return view('bilhete.comprarBilhete', compact('title'));
    }
}
