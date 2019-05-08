<?php

namespace App\Console\Commands;

use App\Models\Img;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use mysql_xdevapi\Exception;
use Webpatser\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;


class Tous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tous:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 70;  // 同时并发抓取

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
        $urls = ['https://www.woyaogexing.com/touxiang/nv/index.html'];
        for($i=2;$i<1527;$i++){
            $urls[] = 'https://www.woyaogexing.com/touxiang/nv/index_'.$i.'.html';
        }
       // $urls = [ 'https://www.woyaogexing.com/touxiang/index.html' , 'https://www.woyaogexing.com/touxiang/index_2.html' , 'https://www.woyaogexing.com/touxiang/index_3.html' , 'https://www.woyaogexing.com/touxiang/index_4.html' , 'https://www.woyaogexing.com/touxiang/index_5.html' , 'https://www.woyaogexing.com/touxiang/index_6.html' ];
        foreach ($urls as $url) {
            try {
                $http    = new Client();
                $data    = $http->get( $url )->getBody()->getContents();
                $crawler = new Crawler();
                $crawler->addHtmlContent( $data );
//                $title = $crawler->filterXPath('//h1')->text();
                $crawler->filterXPath( '//div[@class="pMain"]/div/a[1]/@href' )->each(
                    function ( Crawler $node , $i ) {
//                    return ;
                        echo $node->text();
                        Redis::lpush( 'urls' , $node->text() );
                    }
                );
            } catch (\InvalidArgumentException $exception) {
                echo 'error';
            }
        }


    }
}
