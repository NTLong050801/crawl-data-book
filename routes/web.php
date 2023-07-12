<?php

use Goutte\Client;
use Illuminate\Support\Facades\Route;
use Symfony\Component\DomCrawler\Crawler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $url = route('demo');
    $client = new Client();
    $data = array();
    $crawler = $client->request('GET', $url);

    $node = $crawler->filter('.product-image-summary-inner');
    $image = $node->filter('.product-images .wp-post-image')->attr('src');
    $data['image'] = $image;

    $content = $node->filter('.entry-summary .summary-inner');
    $title = $content->filter('h1.product_title.entry-title')->text();
    $data['title'] = $title;

    $price = $content->filter('.price .amount bdi')->text();
    $data['price'] = $price;

    $content->filter('table.shop_attributes tr')->each(function (Crawler $row) use (&$data) {
        $label = $row->filter('th')->text();
        $value = $row->filter('td p')->text();
        $data[$label] = $value;
    });

    $download = $content->filter('p')->eq(8)->text();
    $data['download'] = $download;

    $detail = $crawler->filter('.wc-tab-inner')->html();
    $data['detail'] = $detail;

    dd($data);
});

Route::get('/demo', function () {
    return view('welcome');
})->name('demo');
