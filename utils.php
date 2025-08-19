<?php
$sectionIndex = 0;

function getBgClass($color = null) {
    global $sectionIndex;

    if ($color) return $color;

    $class = ($sectionIndex % 2 === 0) ? 'bg-light-gray' : 'bg-dark-gray';
    $sectionIndex++;
    return $class;
}

?>
