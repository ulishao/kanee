<?php

namespace App\Console\Commands;

use App\Http\Business\ProxyIpBusiness;
use App\Models\Img;
use Doctrine\DBAL\Query\QueryException;
use GuzzleHttp\Pool;
use function GuzzleHttp\Psr7\parse_header;
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
    private $concurrency = 30;  // 同时并发抓取
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public $url = '';
    public function handle()
    {
        //$this->totalPageCount = count($this->users);

        $client = new Client([ 'headers'=> [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8,sm;q=0.7',
            'Accept-Encoding' => 'gzip'
        ]]);

        $requests = function ($total) use ($client) {
            while (true){
                $uri = 'https://www.woyaogexing.com' . Redis::lpop( 'urls' );
                $this->url = $uri;
                if ( is_null( $uri ) ) {
                    sleep( 1000000 );
                    continue;
                }
                yield function() use ($client, $uri) {
                    return $client->getAsync($uri);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $content = $response->getBody()->getContents();
                $code = mb_detect_encoding($content, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
                if($code == 'UTF-8')
                {
                    $outPageTxt = $content;
                }ELSE{
                    //文本转码
                    $outPageTxt = mb_convert_encoding($content, 'utf-8',$code);
                }
                try{
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($outPageTxt);
                    $title  = $crawler->filterXPath( '//h1' )->text();
                    $urls   = $crawler->filterXPath( '//ul/li/a/img/@src' )->each(
                        function ( Crawler $node , $i ) {
                            return $node->text();
                        }
                    );
                    $urlImg = '';
                    $host   = '';
                    foreach ((array)$urls as $value) {
                        try {
                            $urlImg .= 'https:' . $value . ',';
                            $host   = 'https:' . $value;

                        } catch (\Exception $e) {
                            echo 'error';
                        }
                    }
                    $this->info("请求第 $index 个请求" .$title);

                    Img::create(
                        [ 'id' => Uuid::generate() , 'img' => $host , 'imgs' => $urlImg , 'title' => $title , 'source_url' => $this->url  , 'category_id'=>3]
                    );
                    $this->countedAndCheckEnded();
                } catch (\InvalidArgumentException|\Illuminate\Database\QueryException $exception) {
                    echo 'error';
                }
            },
            'rejected' => function ($reason, $index){
                $this->error("rejected" );
                $this->error("rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        // 开始发送请求
        $promise = $pool->promise();
        $promise->wait();
    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount){
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }
}
