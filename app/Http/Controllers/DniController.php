<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DniController extends Controller
{
    public function consultaDni(Request $request)
    {
        $token = 'apis-token-9861.OTNTMqyCUrCRrOTmpt1Ndl3brvrYPjQe';
        $numero = $request->dni;
        
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://apis.net.pe/api-consulta-dni',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $numero]
        ];

        $res = $client->request('GET', '/v2/reniec/dni', $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return response()->json($response);
    }
}
