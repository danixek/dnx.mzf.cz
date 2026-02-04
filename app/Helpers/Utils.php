<?php

namespace App\Helpers;

class Utils
{
    // statická proměnná pro index sekce
    protected static int $sectionIndex = 0;

    public static function CzechDate(string $date): string
    {

        if (empty($date))
            return '';

        $months = [
            '01' => 'leden',
            '02' => 'únor',
            '03' => 'březen',
            '04' => 'duben',
            '05' => 'květen',
            '06' => 'červen',
            '07' => 'červenec',
            '08' => 'srpen',
            '09' => 'září',
            '10' => 'říjen',
            '11' => 'listopad',
            '12' => 'prosinec'
        ];

        $parts = explode('-', $date);
        if (count($parts) !== 3)
            return '';

        [$year, $month, $day] = $parts;

        if (!isset($months[$month]))
            return '';

        [$year, $month, $day] = $parts;
        return $months[$month] . ' ' . $year;
    }
    
}