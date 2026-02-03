<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Logger
{
    protected static array $blockedIps = [
        "2001:1ae9:15e:bc00:a437:bf78:53d5:d7eb",
        "2001:1ae9:15e:bc00:34b2:24c1:bda8:b9a9",
        "2001:1aef:183:46a7:0:4e:530f:c701",
        "193.86.230.167",
        "194.212.160.90"
    ];

    public static function visit(Request $request, ?string $projectTitle = null): void
    {
        $ip = $request->ip();

        if (in_array($ip, self::$blockedIps, true)) {
            return;
        }

        $date = now()->format('Y-m-d H:i:s');
        $uri  = $request->getRequestUri();
        $ua   = $request->userAgent() ?? '';

        $titlePart = $projectTitle ? htmlspecialchars($projectTitle) . ' ' : '';

        $logLine = "[$date] - {$titlePart}{$uri} - IP: {$ip} - UA: {$ua}" . PHP_EOL;

        $logFile = storage_path('logs/visits.log');

        file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
    }
}
?>