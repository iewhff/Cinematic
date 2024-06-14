<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;

use App\Models\Bilhete;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;



class ControloController extends Controller
{
    public function picarsessao(Request $request){

        $title = 'Escolher Sessão';
        $filmeId = $request->input('filmeId');
        $dataAtual = Carbon::now()->toDateString();
        $horaAtualMenosCincoMinutos = Carbon::now()->subMinutes(5)->toTimeString();

        $sessoes = Sessao::join('salas', 'sessoes.sala_id', '=', 'salas.id')
                        ->where(function ($query) use ($dataAtual, $horaAtualMenosCincoMinutos) {
                            $query->where('sessoes.data', '>', $dataAtual)
                                  ->orWhere(function ($query) use ($dataAtual, $horaAtualMenosCincoMinutos) {
                                      $query->where('sessoes.data', $dataAtual)
                                            ->where('sessoes.horario_inicio', '>=', $horaAtualMenosCincoMinutos);
                                  });
                        })
                        ->select('sessoes.id', 'sessoes.filme_id', 'sessoes.sala_id', 'sessoes.data', 'sessoes.horario_inicio', 'salas.nome as sala_nome')
                        ->get();




        return view('controloAcesso.picarSessao', ['sessoes' => $sessoes, 'title' => $title,'filmeId' => $filmeId]);

     

    }

    public function formN (Request $request){
        $idSessao = $request->input('sessao_id');
   
        return view('controloAcesso.form', ['sessao_id' => $idSessao]);

    }

    public function processarForm(Request $request){

      

        // Obtém o ID da sessão
        $inputBilheteId = $request->input('bilhete_id');
        $idSessao = $request->input('sessao_id');
        $sessaoCorreto = [$idSessao];
        // Procura o bilhete 
        $bilhetes = DB::table('bilhetes')->where('id', $inputBilheteId)->get();

         // Obter os IDs dos bilhetes como array
         $idS = $bilhetes->pluck('sessao_id')->map(function ($sessao_id) {
            return (string) $sessao_id;
        })->toArray();


        // Retorna a resposta com os bilhetes encontrados
        return view('controloAcesso.resultado', ['bilhetes' => $bilhetes, 'idSessao' =>  $sessaoCorreto, 'sessaoBil'=> $idS]);

    }


    public function showBilhete(Request $request, $id, $idSessao)
    {
     
        DB::table('bilhetes')
        ->where('id', $id)
        ->update([
            'estado' => ('usado')
        ]);

        return view('controloAcesso.form', ['sessao_id' =>  $idSessao]);
    }
    

    public function backForm(Request $request)
    {
        // Lógica para armazenar os dados

        $idSessao = $request->input('sessao_id');
       
   
        // Redirecionar de volta à página anterior
        
return redirect()->back();
    }

    
}
