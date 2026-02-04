<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorController extends Controller
{
    public function show(Request $request, $code = 404)
    {
        // Logování návštěvy
        $ip = $request->ip();
        $ua = $request->userAgent();
        $url = $request->fullUrl();
        $logLine = "[$code] - $url - IP: $ip - UA: $ua";
        Log::channel('visits')->info($logLine); // vytvoř si channel 'visits' v config/logging.php

        $errors = [
            403 => ['title' => 'Přístup zamítnut', 'message' => 'Nemáš tu co dělat...'],
            404 => ['title' => 'Nenalezeno', 'message' => 'Smysl [života] nenalezen.'],
            500 => ['title' => 'Chyba serveru', 'message' => 'Něco se uvnitř pokazilo.'],
            418 => ['title' => 'I\'m a teapot', 'message' => 'Jsem čajová konvice, ne kávovar. ☕️']
        ];

        $error = $errors[$code] ?? $errors[404];

        return view('error', [
            'code' => $code,
            'error' => $error,
        ]);
    }
}
