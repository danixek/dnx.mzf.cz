<?php
// Přemapuje to seznam linků na asociativní pole podle typu
$linkMap = [];
foreach ($project->links as $link) {
    if (!empty($link->type) && !empty($link->url)) {
        $linkMap[$link->type] = $link->url;
    }
}

// GitHub – malé tlačítko
if (!empty($linkMap['github'])) {
    $gitUrl = $linkMap['github'];
    $gitIcon = 'bi-github';
    $gitLabel = 'GitHub';

    // Rozlišení GitHub vs GitLab
    if (stripos($gitUrl, 'gitlab.com') !== false) {
        $gitIcon = 'bi-gitlab';
        $gitLabel = 'GitLab';
    } elseif (stripos($gitUrl, 'github.com') === false) {
        // Není to GitHub či GitLab =>externí odkaz
        $gitIcon = 'bi-code';  // Např. pro jiný externí odkaz
        $gitLabel = 'Externí Repo';  // Nebo jakýkoli jiný název
    }

    echo '<a href="' . htmlspecialchars($gitUrl) . '" target="_blank" rel="noopener noreferrer" class="btn btn-md btn-themed me-2">';
    echo '<i class="bi ' . $gitIcon . ' me-1"></i>' . $gitLabel . '</a>';
}
?>
{{-- Preview má přednost před Download – velké tlačítko --}}
@if (!empty($linkMap['preview']))
    <a href="{{ htmlspecialchars($linkMap['preview']) }}" target="_blank" rel="noopener noreferrer" class="btn btn-lg btn-themed ms-3">
        <i class="bi bi-box-arrow-up-right me-1"></i>Náhled</a>
@elseif (!empty($linkMap['download']))
    <a href="{{ htmlspecialchars($linkMap['download']) }}" download class="btn btn-lg btn-themed ms-3">
        <i class="bi bi-download me-1"></i>Stáhnout projekt</a>
@endif
