<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ComprarBilheteController extends Controller
{
    public function create()
    {
        $title = 'Comprar Bilhete';
        return view('bilhete.comprarBilhete', compact('title'));
    }
}
