<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Bilhete;
use Illuminate\Support\Facades\DB;


class ControloController extends Controller
{
    public function processarForm(Request $request){

      

        // Obtém o ID da sessão
        $inputBilheteId = $request->input('bilhete_id');

        // Faça alguma coisa com o ID, por exemplo, buscar bilhetes
        $bilhetes = DB::table('bilhetes')->where('id', $inputBilheteId)->get();
        
        // Retorne a resposta com os bilhetes encontrados
        return view('controloAcesso.resultado', ['bilhetes' => $bilhetes]);

    }


    public function showBilhete($id)
    {
      
        DB::table('bilhetes')
        ->where('id', $id)
        ->update([
            'estado' => ('usado')
        ]);

   

        // Faça alguma coisa com o bilhete, por exemplo, retornar uma view com os dados do bilhete
        return view('controloAcesso.form');
    }
}
