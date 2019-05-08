<?php

namespace App\Console\Commands;

use App\Http\Business\ProxyIpBusiness;
use App\Models\Img;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use mysql_xdevapi\Exception;
use Webpatser\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;


class Tou extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tou:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 7;  // 同时并发抓取

    private $users = [ '1' , 'appleboy' , 'Aufree' , 'lifesign' , 'overtrue' , 'zhengjinghua' , 'NauxLiu' ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        //*[@id="post-76093"]/div/header/h2/a
//        $page = 'http://www.coupling.pw/page/2?s=2019';
//        $http = new Client();
//        $html = $http->get($page)->getBody()->getContents();
//        $crawler = new Crawler();
//        $crawler->addHtmlContent($html);
//        $crawler->filterXPath('//article/div/header/h2/a/@href')->each(function (Crawler $node, $i){
////            $url = $node->text();
        while (true) {
            $url = 'https://www.woyaogexing.com' . Redis::lpop( 'urls' );
            echo $url;
            if ( is_null( $url ) ) {
                sleep( 100 );
                continue;
            }
            try {
                $http    = new Client();
                $data    = $http->get( $url )->getBody()->getContents();
                $crawler = new Crawler();
                $crawler->addHtmlContent( $data );
                $title  = $crawler->filterXPath( '//h1' )->text();
                $urls   = $crawler->filterXPath( '//li[@class="tx-img"]/a/img/@src' )->each(
                    function ( Crawler $node , $i ) {
                        return $node->text();
                    }
                );
                $urlImg = '';
                $host   = '';
                foreach ((array)$urls as $value) {
                    try {
//                         $content = $http->get($value)->getBody()->getContents();
//                         $upload = 'https://sm.ms/api/upload';
//                         $response = $http->request('POST', $upload, [
//                             'multipart' => [
//                                 [
//                                     'name'     => 'smfile',
//                                     'contents' => $content,
//                                     'filename' => 'filename.jpg',
//                                 ]
//                             ]
//                         ]);
//                         $a = json_decode($response->getBody()->getContents(),true)['data']['url'];
//                         $host = $a;
                        $urlImg .= 'https:' . $value . ',';
                        $host   = 'https:' . $value;
                    } catch (\Exception $e) {
                        echo 'error';
                    }
                }
                Img::create(
                    [ 'id' => Uuid::generate() , 'img' => $host , 'imgs' => $urlImg , 'title' => $title , 'source_url' => $url , ]
                );
                echo $title;
            } catch (\InvalidArgumentException $exception) {
                echo 'error';
            }

        }
    }
}
