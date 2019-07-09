<?php

namespace App\Console\Commands;

use App\Models\Img;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use InvalidArgumentException;
use mysql_xdevapi\Exception;
use Webpatser\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;


class Gous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature='gous:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description='Command description';

    private $totalPageCount;
    private $counter=1;
    private $concurrency=70;  // 同时并发抓取

    private $users=[ '1' , 'appleboy' , 'Aufree' , 'lifesign' , 'overtrue' , 'zhengjinghua' , 'NauxLiu' ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct ();
    }


    public function handle()
    {
//        $data = [
//            [
//                'name' => 'shuoshuo' ,
//                'num'  => '600' ,
//            ] ,
//            //            [
//            //                'name' => 'mingxing',
//            //                'num' => '300',
//            //            ],
//            //            [
//            //                'name' => 'fengjing',
//            //                'num' => '300',
//            //            ],
//            //            [
//            //                'name' => 'yingshi',
//            //                'num' => '300',
//            //            ],
//            //            [
//            //                'name' => 'qiche',
//            //                'num' => '300',
//            //            ],
//            //            [
//            //                'name' => 'weimei',
//            //                'num' => '300',
//            //            ],
//        ];
//        foreach ($data as $datum) {
//            $this->D_run ($datum[ 'num' ] , $datum[ 'name' ]);
//        }
        $this->D_run ();
    }

    public function D_run()
    {
        $urls=[
            'http://www.goupu.com.cn/dog/search-htm-page-1-catid-4-sort-.html' ,
        ];
        for ($i=2; $i < 11; $i++) {
            $urls[]='http://www.goupu.com.cn/dog/search-htm-page-' . $i . '-catid-4-sort-.html';
//            $urls[] = 'https://www.woyaogexing.com/' . $key . '/index_' . $i . '.html';
        }
        foreach ($urls as $url) {
            try {
                $http   =new Client();
                $data   =$http->get ($url)->getBody ()->getContents ();
                $crawler=new Crawler();
                $crawler->addHtmlContent ($data);

                $nodel=$crawler->filterXPath ('//div[@class="d1"]/a/@href')->each (
                    function ( Crawler $node , $i ) {

                        $this->info ($node->text ());
                        return $node->text ();
                    }
                );
//                dd ($key , $nodel);
                Redis::lpush ('urls.gous' , $nodel);
            } catch (InvalidArgumentException $exception) {
                echo 'error';
            }
        }
    }
}
