<?php

namespace App\Console\Commands;

use App\Models\Img;
use App\Models\User;
use Exception;
use GuzzleHttp\Pool;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redis;
use InvalidArgumentException;
use Webpatser\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;


class Gou extends Command
{
    public $url=[];
    public $category_id=[];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature='gou:run';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description='Command description';
    private $totalPageCount;  // 同时并发抓取
    private $counter=1;
    private $concurrency=2;

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
        //$this->totalPageCount = count($this->users);

        $client=new Client([
            'headers'=>[
                'User-Agent'     =>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36' ,
                'Accept'         =>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8' ,
                'Accept-Language'=>'zh-CN,zh;q=0.9,en;q=0.8,sm;q=0.7' ,
                'Accept-Encoding'=>'gzip' ,
            ] ,
        ]);
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
        $requests=function ( $total ) use ( $client ) {
            while (true) {
                $key=empty(Redis::keys ('urls.gous')[ 0 ]) ? null : Redis::keys ('urls.gous')[ 0 ];
//                $key = 'https://www.woyaogexing.com/touxiang/nv/2019/780849.html';
                if ( is_null ($key) ) {
                    dd ('停止');
                }

                $uu=Redis::lpop ('urls.gous');
//                if ( strpos ($key , 'weimei') ) {
//                    $uu                  = Redis::lpop ('urls.weimei');
//                    $this->category_id[] = 6;
//                }
//                if ( strpos ($key , 'fengjing') ) {
//                    $uu                  = Redis::lpop ('urls.fengjing');
//                    $this->category_id[] = 1;
//                }
//                if ( strpos ($key , 'yingshi') ) {
//                    $uu                  = Redis::lpop ('urls.yingshi');
//                    $this->category_id[] = 2;
//                }
//                if ( strpos ($key , 'qiche') ) {
//                    $uu                  = Redis::lpop ('urls.qiche');
//                    $this->category_id[] = 4;
//                }
//                if ( strpos ($key , 'mingxing') ) {
//                    $uu                  = Redis::lpop ('urls.mingxing');
//                    $this->category_id[] = 5;
//                }
                $uri=$uu;
//                var_dump($this->category_id);
//                dd($uri);
                $this->url[]=$uri;
                yield function () use ( $client , $uri ) {
                    return $client->getAsync ($uri);
                };
            }
        };

        $pool=new Pool($client , $requests($this->totalPageCount) , [
            'concurrency'=>$this->concurrency ,
            'fulfilled'  =>function ( $response , $index ) {

                $content=$response->getBody ()->getContents ();
                $code   =mb_detect_encoding ($content , [ "ASCII" , 'UTF-8' , "GB2312" , "GBK" , 'BIG5' ]);
                if ( $code == 'UTF-8' ) {
                    $outPageTxt=$content;
                } ELSE {
                    //文本转码
                    $outPageTxt=mb_convert_encoding ($content , 'utf-8' , $code);
                }
                try {
                    $crawler=new Crawler();
                    $crawler->addHtmlContent ($outPageTxt);
                    $title =$crawler->filterXPath ('//span[@class="a1"]')->text ();
                    $title2=$crawler->filterXPath ('//a[@class="a2"]')->text ();
                    $price =$crawler->filterXPath ('//td[10]/a[@class="a3"]')->text ();
                    $img   =$crawler->filterXPath ('//div[@class="pro_left fl"]/img/@src')->text ();

                    $urls=$crawler->filterXPath ('//td/a[@class="a2"]')
                                  ->each (
                                      function ( Crawler $node , $i ) {
                                          return $node->text ();
                                      }
                                  );

                    $content=$crawler->filterXPath ('//div[@class="text clearfix"]')
                                     ->each (
                                         function ( Crawler $node , $i ) {
                                             return $node->text ();
                                         }
                                     );
                    $data   =[
                        'id'        =>Uuid::generate () ,
                        'name'      =>$title ,
                        'url'       =>$img ,
                        'name_en'   =>$title2 ,
                        'name_bie'  =>$urls[ 0 ] ,
                        'region'    =>$urls[ 1 ] ,
                        'place'     =>$urls[ 2 ] ,
                        'shape'     =>$urls[ 3 ] ,
                        'function'  =>$urls[ 4 ] ,
                        'group'     =>$urls[ 5 ] ,
                        'height'    =>$urls[ 6 ] ,
                        'weight'    =>$urls[ 7 ] ,
                        'trait'     =>$urls[ 10 ] ,
                        'life'      =>$urls[ 8 ] ,
                        'introduce' =>$content[ 0 ] ,
                        'price'     =>$price ,
                        'fazhan'    =>$content[ 1 ] ,
                        'renqun'    =>$content[ 2 ] ,
                        'biaozhun'  =>$content[ 3 ] ,
                        'weiyang'   =>$content[ 4 ] ,
                        'jianbie'   =>$content[ 5 ] ,
                        'source_url'=>$this->url[ $index ] ,
                    ];


//                    $instart = [];
                    foreach ($data as $key=>$datum) {
                        $data[ $key ]=str_replace (" " , '' , $datum);
                    }
//                    dd ($data);
//                    $urlImg = '';
//                    $host   = '';
//                    foreach ((array)$urls as $value) {
//                        try {
//                            $urlImg .= 'https:' . $value . ',';
//                            $host   = 'https:' . $value;
//
//                        } catch (Exception $e) {
//                            echo 'error';
//                        }
//                    }

//                    $this->info("请求第 $index 个请求" .$urlImg);
                    $this->info ("请求第 $index 个请求" . $title);
//                    $data = [
//                        'id'          => Uuid::generate () ,
//                        'url'         => $host ,
//                        'urls'        => $urlImg ,
//                        'title'       => $title ,
//                        'source_url'  => $this->url[ $index ] ,
//                        'category_id' => $this->category_id[ $index ],
//                    ];
//                    dd ($data);
                    \App\Models\Gous::createData ($data);
//    dd ($a);
//                    $id   = \App\Models\Bizhi::create ($data);
//                    $urls = $crawler->filterXPath ('//div[@class="tagsL z"]/a/text()')->each (
//                        function ( Crawler $node , $i ) {
//                            return $node->text ();
//                        }
//                    );

//                   \App\Models\Bizhi::createTable ($id[ 'id' ] , $urls);
                    $this->countedAndCheckEnded ();
                } catch (InvalidArgumentException|QueryException $exception) {

                    echo 'error';
                }
            } ,
            'rejected'   =>function ( $reason , $index ) {
                $this->error ("rejected");
                $this->error ("rejected reason: " . $reason);
                $this->countedAndCheckEnded ();
            } ,
        ]);

        // 开始发送请求
        $promise=$pool->promise ();
        $promise->wait ();
    }

    public function countedAndCheckEnded()
    {
        if ( $this->counter < $this->totalPageCount ) {
            $this->counter++;
            return;
        }
        $this->info ("请求结束！");
    }
}
