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
        $data = [
            [
                'name'=>'qinglv',
                'num'=>'463',
            ],
            [
                'name'=>'nan',
                'num'=>'463',
            ],
            [
                'name'=>'nv',
                'num'=>'1527',
            ],
            [
                'name'=>'katong',
                'num'=>'318',
            ],
            [
                'name'=>'fengjing',
                'num'=>'50',
            ],
            [
                'name'=>'weixin',
                'num'=>'40',
            ],
        ];
        foreach ($data as $datum){
            $this->D_run ($datum['num'],$datum['name']);
        }

    }

    public function D_run($num,$key)
    {
        $urls = [
            'https://www.woyaogexing.com/touxiang/'.$key.'/index.html'
        ];
        for($i=2;$i<$num;$i++){
            $urls[] = 'https://www.woyaogexing.com/touxiang/'.$key.'/index_'.$i.'.html';
        }
        foreach ($urls as $url) {
            try {
                $http    = new Client();
                $data    = $http->get( $url )->getBody()->getContents();
                $crawler = new Crawler();
                $crawler->addHtmlContent( $data );
                $nodel = $crawler->filterXPath( '//div[@class="pMain"]/div/a[1]/@href' )->each(
                    function ( Crawler $node , $i ) {

                        $this->info ($node->text());
                        return $node->text();
                    }
                );
                Redis::lpush( 'urls.'.$key , $nodel );
            } catch (\InvalidArgumentException $exception) {
                echo 'error';
            }
        }
    }
}
