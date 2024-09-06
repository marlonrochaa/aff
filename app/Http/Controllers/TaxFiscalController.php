<?php

namespace App\Http\Controllers;

use App\Services\TaxFiscal;
use Illuminate\Http\Request;

class TaxFiscalController extends Controller
{
    public function getTax(Request $request)
    {
        $team = $request->user()->teams[0];

        //verifica se o team ainda tem créditos
        if ($team->credits <= 0) {
            return response()->json(['message' => 'Sem créditos'], 403);
        }

        $data = $request->validate([
            'ncm' => 'required',
            'tipoitem' => 'required',
            'estadoorigem' => 'required',
            'estadodestino' => 'required',
            'entradasaida' => 'required',
        ]);

        $taxFiscal = new TaxFiscal();
        $response = $taxFiscal->getTaxFiscal($team, $data);
      

        return response()->json($response);
    }
}