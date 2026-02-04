<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Parsedown;
use Spyc;

class BlogController extends Controller
{
    protected string $postsPath;
    protected string $thumbsPath;

    public function __construct()
    {
        // cesta k Markdown souborům
        $this->postsPath = resource_path('blog/');
        $this->thumbsPath = 'assets/blog/';
    }

    public function index(Request $request)
    {
        $slug = $request->query('post');

        if ($slug) {
            return $this->showPost($slug);
        }

        return $this->listPosts();
    }

    // Výpis všech článků
    private function listPosts()
    {
        $Parsedown = new Parsedown();

        $files = glob($this->postsPath . '/*.md');

        $posts = [];

        foreach ($files as $file) {
            $filename = basename($file, '.md');
            $content = file_get_contents($file);

            // parse YAML metadata
            if (preg_match('/^---\s*(.*?)\s*---\s*(.*)$/s', $content, $matches)) {
                $yaml = Spyc::YAMLLoadString($matches[1]);
                $body = $matches[2];
            } else {
                $yaml = [];
                $body = $content;
            }

            $posts[] = [
                'slug' => $filename,
                'title' => $yaml['title'] ?? $filename,
                'image' => $this->thumbsPath . ($yaml['image'] ?? 'default-thumb.png'),
                'excerpt' => mb_substr(strip_tags($Parsedown->text($body)), 0, 90),
            ];
        }

        return view('pages.blog', [
            'posts' => $posts,
        ]);
    }

    // Zobrazení detailu jednoho článku
    private function showPost(string $slug)
    {
        $Parsedown = new Parsedown();
        $filePath = $this->postsPath . "/$slug.md";

        if (!file_exists($filePath)) {
            abort(404, 'Článek nenalezen');
        }

        $content = file_get_contents($filePath);

        if (preg_match('/^---\s*(.*?)\s*---\s*(.*)$/s', $content, $matches)) {
            $meta = Spyc::YAMLLoadString($matches[1]);
            $markdown = $matches[2];
        } else {
            $meta = [];
            $markdown = $content;
        }

        return view('pages.blog', [
            'slug' => $slug,
            'title' => $meta['title'] ?? $slug,
            'subtitle' => $meta['subtitle'] ?? '',
            'image' => $this->thumbsPath . ($meta['image'] ?? 'default-thumb.png'),
            'date' => $meta['date'] ?? null,
            'tags' => $meta['tags'] ?? [],
            'content' => $Parsedown->text($markdown)
        ]);
    }

}
