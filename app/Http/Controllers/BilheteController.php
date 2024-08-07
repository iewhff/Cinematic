<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Bilhete;
use App\Models\Recibo;
use App\Models\Lugar;
use Dompdf\Dompdf;
use Dompdf\Options;

class BilheteController extends Controller
{

    public function create()
    {
        $title = 'Comprar Bilhete';
        return view('bilhete.bilhete', compact('title'));
    }

    public function mostrar($id)
    {
        if (Auth::user()->tipo == 'C') {

            $bilhete = Bilhete::where('cliente_id', Auth::user()->id)
                ->where('id', $id)
                ->with(['sessao.sala.lugares', 'sessao.filme'])
                ->first();

            if ($bilhete) {
                $lugares = Lugar::where('id', $bilhete->lugar_id)->get(['id', 'fila', 'posicao']);
                $bilhete->lugar = $lugares->first(); // Associando o lugar ao bilhete
            }


            $title = 'Histórico';



            return view('bilhete.bilhete', compact('title', 'bilhete'));
        } else {
            $h1 = 'Pedimos Desculpa';
            $title = 'Pedimos Desculpa';
            $msgErro = 'Houver um erro.';
            return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
        }
    }

    public function downloadBilhetePdf($id)
    {

        $bilhete = Bilhete::where('cliente_id', Auth::user()->id)
            ->where('id', $id)
            ->with(['sessao.sala.lugares', 'sessao.filme'])
            ->first();

        if ($bilhete) {
            $lugares = Lugar::where('id', $bilhete->lugar_id)->get(['id', 'fila', 'posicao']);
            $bilhete->lugar = $lugares->first(); // Associando o lugar ao bilhete
        }

        // Seus dados em HTML
        $html = '<h1>Cinematic</h1>';
        $html .= '<hr>';
        $html .= '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">' . $bilhete->sessao->filme->titulo . '</h5>';
        $html .= '<p class="card-text">O filme começa às:' . $bilhete->sessao->horario_inicio . '</p>';
        $html .= '<p class="card-text">Sala:' . $bilhete->sessao->sala->nome . '</p>';
        $html .= '<p class="card-text">Lugar:' . $bilhete->lugar->fila . $bilhete->lugar->posicao . '</p>';
        $html .= '<p class="card-text">' . $bilhete->preco_sem_iva . '€</p>';
        $html .= '<p class="card-text"> Nr bilhete: ' . $bilhete->id . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        // Cria uma nova instância do Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Carrega o HTML no Dompdf
        $dompdf->loadHtml($html);

        // Renderiza o PDF
        $dompdf->render();

        // Obtém o conteúdo do PDF gerado
        $pdfContent = $dompdf->output();

        // Define o nome do arquivo PDF, retira caracteres especiais e espacos do nome do filme
        $fileName = 'cinematic_' . preg_replace('/[^a-zA-Z0-9]/', '', $bilhete->sessao->filme->titulo) . '.pdf';

        // Retorna uma resposta com o PDF para download
        return response()->streamDownload(
            fn () => print($pdfContent),
            $fileName
        );
    }

    public function downloadReciboPdf($id)
    {

        $recibo = Recibo::where('cliente_id', Auth::user()->id)
            ->where('id', $id)
            ->first();

        if (!$recibo) {
            $h1 = 'Pedimos Desculpa';
            $title = 'Pedimos Desculpa';
            $msgErro = 'Houver um erro.';
            return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
        }

        // Seus dados em HTML
        $html = '<h1>Recibo</h1>';
        $html .= '<h1>Cinematic</h1>';
        $html .= '<hr>';
        $html .= '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">Recibo NR: ' . $recibo->id . '</h5>';
        $html .= '<p class="card-text">Data: ' . $recibo->data . '</p>';
        $html .= '<p class="card-text">Preço sem IVA: ' . $recibo->preco_total_sem_iva . '€</p>';
        $html .= '<p class="card-text">Preço com IVA: ' . $recibo->preco_total_com_iva . '€</p>';
        $html .= '<p class="card-text">NIF: ' . $recibo->nif . '</p>';
        $html .= '<p class="card-text">Nome do cliente: ' . $recibo->nome_cliente . '</p>';
        $html .= '<p class="card-text">Tipo de pagamento: ' . $recibo->tipo_pagamento . '</p>';
        $html .= '<p class="card-text">Referencia de pagamento: ' . $recibo->ref_pagamento . '</p>';
        $html .= '<hr>';
        $html .= '<p class="card-text"> Volte sempre </p>';
        $html .= '<hr>';
        $html .= '<h1>Cinematic</h1>';
        $html .= '<hr>';
        $html .= '</div>';
        $html .= '</div>';

        // Cria uma nova instância do Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Carrega o HTML no Dompdf
        $dompdf->loadHtml($html);

        // Renderiza o PDF
        $dompdf->render();

        // Obtém o conteúdo do PDF gerado
        $pdfContent = $dompdf->output();

        // Define o nome do arquivo PDF, retira caracteres especiais e espacos do nome do filme
        $fileName = 'recibo_cinematic_' . $recibo->id . '.pdf';

        // Retorna uma resposta com o PDF para download
        return response()->streamDownload(
            fn () => print($pdfContent),
            $fileName
        );
    }
}
