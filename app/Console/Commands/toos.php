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


class Toos extends Command
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
        $data = [
            [
                'name' => 'qinglv' ,
                'num'  => '3' ,
            ] ,
            [
                'name' => 'nan' ,
                'num'  => '3' ,
            ] ,
            [
                'name' => 'nv' ,
                'num'  => '3' ,
            ] ,
            [
                'name' => 'katong' ,
                'num'  => '3' ,
            ] ,
            [
                'name' => 'fengjing' ,
                'num'  => '3' ,
            ] ,
            [
                'name' => 'weixin' ,
                'num'  => '3' ,
            ] ,
        ];
        foreach ($data as $datum) {
            $this->D_run( $datum[ 'num' ] , $datum[ 'name' ] );
        }

    }

    public function D_run( $num , $key )
    {
//        $urls = [
//            'https://www.woyaogexing.com/touxiang/'.$key.'/index.html'
//        ];
//        for($i=2;$i<$num;$i++){
//            $urls[] = 'https://www.woyaogexing.com/touxiang/'.$key.'/index_'.$i.'.html';
//        }
        $urls = Img::all()->toArray();
        foreach ($urls as $url) {
            try {
//                $http    = new Client();
//                $data    = $http->get( $url )->getBody()->getContents();
//                $crawler = new Crawler();
//                $crawler->addHtmlContent( $data );
//                $nodel = $crawler->filterXPath( '//div[@class="pMain"]/div/a[1]/@href' )->each(
//                    function ( Crawler $node , $i ) {
//
//                        $this->info ($node->text());
//                        return $node->text();
//                    }
//                );
                Redis::lpush( 'urls.label' , $url );
            } catch (InvalidArgumentException $exception) {
                echo 'error';
            }
        }
    }
}
