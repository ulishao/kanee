<?php

namespace App\Console\Commands;

use App\Models\Img;
use GuzzleHttp\Pool;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
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
    private $concurrency = 2;  // 同时并发抓取
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public $url = [];
    public $category_id = [];
    public function handle()
    {
        //$this->totalPageCount = count($this->users);

        $client = new Client([ 'headers'=> [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8,sm;q=0.7',
            'Accept-Encoding' => 'gzip'
        ]]);
//        [
//            'name'=>'qinglv',
//            'num'=>'463',
//        ],
//            [
//                'name'=>'nan',
//                'num'=>'463',
//            ],
//            [
//                'name'=>'nv',
//                'num'=>'1527',
//            ],
//            [
//                'name'=>'katong',
//                'num'=>'318',
//            ],
//            [
//                'name'=>'fengjing',
//                'num'=>'50',
//            ],
//            [
//                'name'=>'weixin',
//                'num'=>'40',
//            ],
        $requests = function ($total) use ($client) {
            while (true){
                $key = empty(Redis::keys( 'urls.*')[0])?null:Redis::keys( 'urls.*')[0];
//                $key = 'https://www.woyaogexing.com/touxiang/nv/2019/780849.html';
                if(is_null($key)){
                    dd('停止');
                }
                if(strpos($key,'nv'))
                {
                    $uu = Redis::lpop( 'urls.nv');
                    $this->category_id[] = 3;
                }
                if(strpos($key,'weixin'))
                {
                    $uu = Redis::lpop( 'urls.weixin');
                    $this->category_id[] = 6;
                }
                if(strpos($key,'qinglv'))
                {
                    $uu = Redis::lpop( 'urls.qinglv');
                    $this->category_id[] = 1;
                }
                if(strpos($key,'nan'))
                {
                    $uu = Redis::lpop( 'urls.nan');
                    $this->category_id[] = 2;
                }
                if(strpos($key,'katong'))
                {
                    $uu = Redis::lpop( 'urls.katong');
                    $this->category_id[] = 4;
                }
                if(strpos($key,'fengjing'))
                {
                    $uu = Redis::lpop( 'urls.fengjing');
                    $this->category_id[] = 5;
                }
                $uri = 'https://www.woyaogexing.com' . $uu;
//                var_dump($this->category_id);
//                dd($uri);
                $this->url[] = $uri;
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
                    $urls   = $crawler->filterXPath( '//ul[@class="artCont cl"]/li/a/img/@src | //ul[@class="artCont cl"]/li/img/@src' )->each(
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

//                    $this->info("请求第 $index 个请求" .$urlImg);
                    $this->info("请求第 $index 个请求" .$title);
                    $data = [
                        'id' => Uuid::generate() ,
                              'img' => $host ,
                              'imgs' => $urlImg ,
                              'title' => $title ,
                              'source_url' => $this->url[$index]  ,
                              'category_id'=>$this->category_id[$index]
                    ];
                    Img::create($data);
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
