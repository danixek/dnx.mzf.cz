<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('set')) {
            return $this->settings($request);
        }

        if ($request->has('rss')) {
            return $this->rss($request);
        }

        // výchozí stav
        return $this->dash($request);
    }

    // Main Page
    private function dash(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'tab' => 'dash',
            'user' => $user,
            'bookmarks' => $this->dashBookmarks($user),
            'preferences' => $this->dashPreferences($user),
        ]);
    }
    // RSS Feed Page
    private function rss(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'tab' => 'rss',
            'user' => $user,
            'feedItems' => $this->dashFeedItems($user),
            'preferences' => $this->dashPreferences($user),
        ]);
    }
    // Settings Page
    private function settings(Request $request)
    {
        $user = $request->user();

        $dashBookmarks = collect();
        $dashFeeds = collect();

        if ($user) {

            $dashBookmarks = DB::table('dash_bookmarks')
                ->where('user_id', $user->id)
                ->get();

            $dashFeeds = DB::table('dash_rss')
                ->where('user_id', $user->id)
                ->get();
        }

        $wallpaperPositionsList = [
            'center center' => 'Na střed',
            'left center' => 'Vlevo',
            'right center' => 'Vpravo'
        ];
        $searchEngines = [
            'google' => 'Google',
            'duckduckgo' => 'DuckDuckGo',
            'bing' => 'Bing',
            'seznam' => 'Seznam',
            'brave' => 'Brave'
        ];

        $wallpapers = collect(
            glob(public_path('dashboard/img/*.jpg'))
        )->map(fn($f) => basename($f));

        return view('dashboard', [
            'tab' => 'set',
            'user' => $user,
            'feeds' => $dashFeeds,
            'preferences' => $this->dashPreferences($user),
            'bookmarks' => $dashBookmarks,
            'engines' => $searchEngines,
            'wallpaperPositionsList' => $wallpaperPositionsList ?? [],
            'wallpapers' => $wallpapers,
        ]);
    }

    public function saveSettings(Request $request)
    {
        $user = $request->user();
        if (!$user)
            abort(403);

        // Preferences
        $preferences = $request->validate([
            'wallpaper' => 'required|string',
            'wallpaper_position' => 'required|string',
            'search_engine' => 'required|string',
        ]);

        DB::table('dash_preferences')->updateOrInsert(
            ['user_id' => $user->id],
            $preferences
        );

        // Bookmarks
        $bookmarks = $request->input('bookmarks', []);
        foreach ($bookmarks as $bookmark) {
            DB::table('dash_bookmarks')->updateOrInsert(
                [
                [
                    'user_id' => $user->id,
                    'id' => $bookmark['id'] ?? null],
                ],
                [
                    'user_id' => $user->id,
                    'url' => $bookmark['url'] ?? '',
                    'title' => $bookmark['title'] ?? '',
                    'category' => $bookmark['category'] ?? '',
                ]
            );
        }

        // RSS feeds
        $rssFeeds = $request->input('rss', []);
        foreach ($rssFeeds as $feed) {
            DB::table('dash_rss')->updateOrInsert(
                ['user_id' => $user->id, 'id' => $feed['id'] ?? null],
                ['user_id' => $user->id, 'feed_url' => $feed['feed_url'] ?? '']
            );
        }

        return redirect()->route('dashboard', ['set' => true])
            ->with('success', 'Nastavení uloženo.');
    }


    private function dashPreferences($user): object
    {
        $db = $user
            ? DB::table('dash_preferences')->where('user_id', $user->id)->first()
            : null;

        return (object) [
            'wallpaper' => $db->wallpaper ?? 'tokyo-city-wallpaper.jpg',
            'wallpaperPosition' => $db->wallpaper_position ?? 'center center',
            'searchEngine' => $db->search_engine ?? 'google',
        ];
    }
    private function dashBookmarks($user): array
    {

        $dashBookmarks = collect();
        if ($user) {
            $dashBookmarks = DB::table('dash_bookmarks')
                ->where('user_id', $user->id)
                ->get();
        }

        return $dashBookmarks->toArray();
    }
    private function dashFeedItems($user)
    {

        $feeds = [];
        if (!$user) {
            return [];
        }

        $feeds = DB::table('dash_rss')
            ->where('user_id', $user->id)
            ->get(['id', 'feed_url'])
            ->toArray();

        return $this->loadRssItems($feeds);
    }

    private function loadRssItems(array $rssSources)
    {
        $items = [];
        libxml_use_internal_errors(true);

        foreach ($rssSources as $source) {
            $xml = @simplexml_load_file($source->feed_url ?? '');
            if (!$xml || !isset($xml->channel->item)) {
                continue;
            }

            foreach ($xml->channel->item as $entry) {
                $items[] = [
                    'id' => $source->id ?? null,
                    'title' => (string) ($entry->title ?? ''),
                    'link' => (string) ($entry->link ?? ''),
                    'description' => strip_tags((string) ($entry->description ?? '')),
                    'pubDate' => isset($entry->pubDate)
                        ? strtotime((string) $entry->pubDate)
                        : null,
                    'image' => isset($entry->enclosure['url'])
                        ? (string) $entry->enclosure['url']
                        : null,
                ];
            }
        }

        libxml_clear_errors();

        // seřazení od nejnovějšího
        usort($items, fn($a, $b) => ($b['pubDate'] ?? 0) <=> ($a['pubDate'] ?? 0));

        return $items;
    }

}