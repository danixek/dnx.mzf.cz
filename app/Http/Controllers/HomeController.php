<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Logger;

class HomeController extends BaseController
{
    public function index()
    {
        // Načíst projekty s jejich badges
        $projects = DB::table('projects as p')
            ->leftJoin('project_badges as pb', 'pb.project_id', '=', 'p.id')
            ->leftJoin('badges as b', 'b.id', '=', 'pb.badge_id')
            ->select(
                'p.id',
                'p.title',
                'p.short_description',
                'p.tags',
                'p.thumbnail',
                DB::raw('GROUP_CONCAT(b.id) as badges'),
                DB::raw('GROUP_CONCAT(b.status_background_color) as badges_bg'),
                DB::raw('GROUP_CONCAT(b.status_text_color) as badges_text')
            )
            ->groupBy('p.id', 'p.title', 'p.short_description', 'p.tags', 'p.thumbnail')
            ->get()
            ->map(function ($project) {
                // Tagy
                $project->tagsArray = array_map('strtolower', array_map('trim', explode(',', $project->tags ?? '')));
                $project->dataTech = implode(',', $project->tagsArray);

                // Badge keys
                $project->badgeKeys = explode(',', $project->badges ?? []);
                $project->dataVersion = implode(',', array_map('strtolower', $project->badgeKeys));

                // Thumbnail
                $defaultBase64 = 'data:image/png;base64,...'; // zkráceno
                $thumbPath = public_path('assets/portfolio/gallery/' . ($project->thumbnail ?? ''));
                $project->thumbnailUrl = ($project->thumbnail && file_exists($thumbPath))
                    ? 'assets/portfolio/gallery/' . $project->thumbnail
                    : $defaultBase64;

                return $project;
            });

        // Načíst všechny badges zvlášť
        $badges = DB::table('badges')->get()->keyBy('id');

        // Počet projektů
        $totalProjects = DB::table('projects')->count();

        $techGroups = [
            'programming_languages' => [
                ['tech' => 'c#', 'label' => 'C#', 'title' => 'C# - programovací jazyk'],
                ['tech' => 'javascript', 'label' => 'JS/TS', 'title' => 'Javascript/Typescript - využívá se ve webovém vývoji'],
                ['tech' => 'python', 'label' => 'Python', 'title' => 'Prostě python'],
            ],
            'frameworks' => [
                ['tech' => 'asp.net', 'label' => 'ASP.NET', 'title' => 'C# technologie pro tvorbu webových aplikací'],
                ['tech' => 'wpf', 'label' => 'WPF', 'title' => 'C# technologie pro tvorbu UI programů'],
                ['tech' => 'api', 'label' => 'API', 'title' => 'Rozhraní pro komunikaci mezi aplikacemi'],
                ['tech' => 'bootstrap', 'label' => 'Bootstrap', 'title' => 'CSS framework pro rychlou tvorbu moderních a responzivních webů'],
                ['tech' => 'sql', 'label' => 'SQL', 'title' => 'Do SQL spadá MSSQL a MySQL, a další.'],
            ],
        ];

        // Data pro view
        return view('home', [
            'projects' => $projects,
            'badges' => $badges,
            'totalProjects' => $totalProjects,
            'techGroups' => $techGroups,
        ]);
    }
    public function detail(Request $request)
    {
        Logger::visit($request);
        $id = $request->query('id'); // nebo $request->id

        // Načteme hlavní projekt
        $project = DB::table('projects')->where('id', $id)->first();

        if (!$project) {
            abort(404, 'Projekt nenalezen.');
        }

        // Tagy a thumbnail
        $project->tagsArray = array_map('strtolower', array_map('trim', explode(',', $project->tags ?? '')));
        $project->dataTech = implode(',', $project->tagsArray);

        $defaultBase64 = 'data:image/png;base64,...'; // zkráceno
        $thumbPath = public_path('assets/portfolio/gallery/' . ($project->thumbnail ?? ''));
        $project->thumbnailUrl = ($project->thumbnail && file_exists($thumbPath))
            ? 'assets/portfolio/gallery/' . $project->thumbnail
            : $defaultBase64;

        // Galerie
        $project->gallery = DB::table('project_gallery')
            ->where('project_id', $id)
            ->pluck('image')
            ->toArray();

        // Changelog
        $project->changelog = DB::table('project_changelog')
            ->where('project_id', $id)
            ->orderBy('date', 'desc')
            ->get();

        // Odkazy
        $project->links = DB::table('project_links')
            ->where('project_id', $id)
            ->get();

        // Badges
        $badges = DB::table('badges')->get()->keyBy('id');
        $project->projectBadges = DB::table('project_badges')
            ->where('project_id', $id)
            ->pluck('badge_id')
            ->toArray();

        $project->dataVersion = implode(',', array_map('strtolower', $project->projectBadges));

        // Posíláme do Blade
        return view('detail', [
            'project' => $project,
            'badges' => $badges
        ]);
    }
    public function library(Request $request)
    {
        $l = (int) $request->get('l', 0);

        $map = [
            0 => 'Přednášky',
            1 => 'Filmy+',
            2 => 'Hry',
        ];

        $category = $map[$l] ?? 'Přednášky';

        $jsonPath = storage_path('data/library.json');

        if (!file_exists($jsonPath)) {
            return view('library', [
                'items' => [],
                'category' => $category,
            ]);
        }

        $data = json_decode(file_get_contents($jsonPath), true);

        if (!is_array($data) || !isset($data[$category])) {
            return view('library', [
                'items' => [],
                'category' => $category,
            ]);
        }

        $items = collect($data[$category])
            ->filter(fn ($item) => ($item['visibility'] ?? 'visible') !== 'hidden')
            ->map(fn ($item) => $this->prepareItem($item))
            ->values();

        return view('library', compact('items', 'category'));
    }

    private function prepareItem(array $item): array
    {
        // TAGY
        $tags = is_array($item['tags'] ?? null)
            ? $item['tags']
            : explode(',', $item['tags'] ?? '');

        $tags = collect($tags)
            ->map(fn ($t) => strtolower(trim(strip_tags($t))))
            ->implode(',');

        // THUMBNAIL
        $defaultBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=';

        $thumbFile = $item['thumbnail'] ?? ($item['gallery'][0] ?? null);

        if ($thumbFile) {
            $publicPath = 'assets/library/' . ltrim($thumbFile, '/');
            $fullPath = public_path($publicPath);
            $thumbnail = file_exists($fullPath) ? '/' . $publicPath : $defaultBase64;
        } else {
            $thumbnail = $defaultBase64;
        }

        return [
            'title'            => $item['title'] ?? '',
            'shortDescription' => $item['shortDescription'] ?? '',
            'tags'             => $tags,
            'thumbnail'        => $thumbnail,
            'url'              => $item['url'] ?? '#',
        ];
    }
}
?>