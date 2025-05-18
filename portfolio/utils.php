<?php
$sectionIndex = 0;

function getBgClass($exception = false) {
    global $sectionIndex;

    if ($exception) {
        return 'bg-white'; // nebo jiná pevná třída
    }

    $class = ($sectionIndex % 2 === 0) ? 'bg-light-gray' : 'bg-dark-gray';
    $sectionIndex++;

    return $class;
}
?>
