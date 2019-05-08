<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use mysql_xdevapi\Exception;
use Symfony\Component\DomCrawler\Crawler;


class Spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:run';

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
        $page    = 'http://www.coupling.pw/page/2?s=2019';
        $http    = new Client();
        $html    = $http->get( $page )->getBody()->getContents();
        $crawler = new Crawler();
        $crawler->addHtmlContent( $html );
        $crawler->filterXPath( '//article/div/header/h2/a/@href' )->each(
            function ( Crawler $node , $i ) {
                $url = $node->text();
                echo $url;
                try {
                    $http    = new Client();
                    $data    = $http->get( $url )->getBody()->getContents();
                    $crawler = new Crawler();
                    $crawler->addHtmlContent( $data );
                    $herf = $crawler->filterXPath( '//div[@class="entry-content"]/p[contains(string(), "密码")]/a/@href' )->text();
                    $a    = $crawler->filterXPath( '//div[@class="entry-content"]/p[contains(string(), "密码")]' )->text();
                    $d    = substr( $a , strrpos( $a , "密码：" ) + 7 , strlen( $a ) );
                    echo $herf . '密码：' . $d . '\n';
                    echo 'hi\nhi';
                } catch (\InvalidArgumentException $exception) {
                    echo 'error';
                }

            }
        );
//  var_dump($d);
    }
}
