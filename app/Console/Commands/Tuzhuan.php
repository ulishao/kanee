<?php

namespace App\Console\Commands;

use App\Libs\Qiniu\Qiniu;
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


class Tuzhuan extends Command
{
    public $url = [];
    public $category_id = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:run';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $totalPageCount;  // 同时并发抓取
    private $counter = 1;
    private $concurrency = 2;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct ()
    {
        parent::__construct();
    }

    public function handle ()
    {
        $i = 10;
        Img::query()->where('qq_imgs', '=', '')->chunk(10, function ( $model ) use ( $i ) {
            echo $i . '<br>';
            foreach ($model as $item) {
                $qq_imgs = [];
                foreach ($item->imgs as $img) {

                    $data = file_get_contents($img);
                    $url = Qiniu::upload('user', $data);
                    $qq_imgs[] = $url[ 'host_url' ];
                }
                echo $item->id . '-' . $item->title . '<br>';
                Img::query()->where(['id' => $item->id])->update([
                    'qq_imgs' => implode(",", $qq_imgs)
                ]);
            }
            $i = $i + 10;
        });
    }

    public function countedAndCheckEnded ()
    {
        if ( $this->counter < $this->totalPageCount ) {
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }
}
