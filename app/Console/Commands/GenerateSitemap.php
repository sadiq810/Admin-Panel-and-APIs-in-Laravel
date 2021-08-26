<?php

namespace App\Console\Commands;

use App\Http\Controllers\LanguageController;
use App\Models\Category;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating sitemap started....');
        $categories = Category::withCount(['content' => function($q) {
            return $q->where('language_id', 1);
        }])->get();

        $languages = (new LanguageController())->getActiveLanguages();

        $sitemap = SitemapGenerator::create(env('APP_URL').'/crawler')
            ->hasCrawled(function (Url $url) {
                if ($url->segment(1) === 'crawler' || $url->segment(1) === 'api' || $url->segment(1) === 'change-language' || stripos($url->url, 'page=')
                    || stripos($url->url, 'sorting') || stripos($url->url, 'change-language') || $url->segment(2) == 'change-language')
                    return;

                return $url;
            })->getSitemap();

        $categories->each(function($category) use(&$sitemap, $languages) {
           for ($i = 1; $i <= $category->content_count; $i++) {
               //foreach ($languages as $lang) {
                  // $url = env('APP_URL')."/{$lang->short_name}/dua?cat={$category->id}&page={$i}";
                   $url = env('APP_URL')."/ar/dua?cat={$category->id}&page={$i}";
                   $sitemap->add(Url::create($url)->setPriority(0.8));
               //}
           }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully !!!');
    }
}
