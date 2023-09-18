<?php

namespace App\Console\Commands;

use Goutte\Client;
use Illuminate\Console\Command;

class CrawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://roufily.com/product/living-with-art-12th-edition-by-mark-getlein-pdf-ebook/';

        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('.product-image-summary-inner')->each(
            function (Crawler $node) {
                $title = $node->filter('.product-images > img ')->extract(['src']);
                dd($title);
            }
        );
    }
}
