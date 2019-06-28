<?php

namespace App\Console\Commands;

use App\Models\Img;
use App\Models\User;
use DB;
use Exception;
use GuzzleHttp\Pool;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redis;
use InvalidArgumentException;
use Webpatser\Uuid\Uuid;
use Symfony\Component\DomCrawler\Crawler;


class Tu extends Command
{
    public $url=[];
    public $category_id=[];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature='tu:run';
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
        DB::table ("bizhis")->chunkById (100 , function ( $items ) {
            /**
             * $items是100条数据的集合
             * @var Collection $items
             */
            $items->each (function ( $row ) {
                //
                $url=$row->url;
                $ch =curl_init (); //初始化curl
                curl_setopt ($ch , CURLOPT_URL , $url); //设置链接
                curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1); //设置是否返回信息
                curl_setopt ($ch , CURLOPT_POST , 0); //设置为GET方式
                curl_setopt ($ch , CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 6.1; WOW64)');
                curl_setopt ($ch , CURLOPT_HEADER , false);
                curl_setopt ($ch , CURLOPT_NOBODY , true);
                curl_setopt ($ch , CURLOPT_FOLLOWLOCATION , true); // 是否跟踪301或302递归
                $res     =curl_exec ($ch);
                $httpCode=curl_getinfo ($ch , CURLINFO_HTTP_CODE);
                curl_close ($ch);
                if ( $httpCode != 200 ) {
                    //图片不存在
                    //删除图片
                    DB::table ('bizhis')->where ([ 'id'=>$row->id ])->delete ();
                    $this->info ('id' . $row->id . '删除' . $row->url);
                }
                $this->info ('id' . $row->id . '正常' . $row->url);
            });
        });
    }
}
