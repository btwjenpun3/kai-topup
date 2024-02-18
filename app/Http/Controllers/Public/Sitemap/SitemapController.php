<?php

namespace App\Http\Controllers\Public\Sitemap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Contracts\Sitemapable;
use App\Models\Game;

class SitemapController extends Controller
{
    public function build_index()
    {
        $games = Game::all();
        $urls = [];
        foreach($games as $game) {
            $url = Url::create('/topup/' . $game->slug)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                    ->setPriority(0.7);
            $urls[] = $url;           
        }
        return $urls;        
    }

    public function index()
    {
        Sitemap::create()
            ->add(Url::create('/')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0))                
            ->add($this->build_index())
            ->add(Url::create('/harga')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                ->setPriority(0.5))
            ->add(Url::create('/tentang-kami')
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.5))
            ->writeToFile(public_path('sitemap.xml'));
    }
}
