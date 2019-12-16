<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole websocket';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //创建server
        $server = new \Swoole\WebSocket\Server("0.0.0.0", 9501);

        //连接成功回调
        $server->on('open', function (\Swoole\WebSocket\Server $server, $request) {
            $this->info($request->fd . '链接成功');
            //插入数据库
//            db($request->fd);
//            $m = file_get_contents( __DIR__ .'/log.txt');
            $retunr=array(
                'code'=>'0',
                'message'=> $request->fd.'--欢迎进入贪吃蛇大作战'
            );
            $server->push($request->fd,json_encode($retunr));

            //通知所有玩家
            $userinfo=[
                'fq'=>$request->fd,
                'name'=>"玩家".$request->fd
            ];
            $requestFd=json_encode(array(
                'code'=>'4002',
                'message'=>$userinfo['name'].'--进入房间'
            ));
            var_dump($_SESSION['users']);
            foreach($_SESSION["users"] as $k=>$i){
                $server->push($i, $requestFd );
            }
            $_SESSION["users"][$request->fd] = $userinfo;
            echo count($_SESSION['users'])."\n";
//            file_put_contents( __DIR__ .'/log.txt' , $request->fd);
        });

        //收到消息回调
        $server->on('message', function (\Swoole\WebSocket\Server $server, $frame) {
            //
//            $m = file_get_contents( __DIR__ .'/log.txt');
//            $data=explode(',',$frame->data);
            $data=explode(',',$frame->data);
            $array=json_decode($frame->data,true);
//    foreach(){
//        $server->push($i, $requestFd );
//    }
            foreach ($_SESSION["users"] as $i) {
                if($array['code']==200){
                    $requestArray=json_encode(array(
                        'code'=>'4007',
                        'fq'=>$frame->fd,
                        'message'=> '玩家'.$frame->fd.'说:'.$array['message']
                    ));
                    $server->push($i, $requestArray);
                }else{
                    $requestArray=json_encode(array(
                        'code'=>'4006',
                        'fq'=>$frame->fd,
                        'message'=>$frame->data
                    ));

                    $server->push($i, $requestArray);
                    echo 'fd=' . $i . 'm=' . $frame->fd . "\n";
                }
            }
            //

//            $content = $frame->data;
//
//            //推送给所有链接
//            foreach ($server->connections as $fd){
//                $server->push($fd,$content);
//            }
        });

        //关闭链接回调
        $server->on('close', function ($server, $fd) {
//            $m = file_get_contents( __DIR__ .'/log.txt');
            unset($_SESSION["user"][$fd]);
            $requestFd=json_encode(array(
                'code'=>'4003',
                'message'=>$_SESSION['users'][$fd]['name'].'---退出房间'
            ));
            foreach ($_SESSION["users"] as $i) {
                $server->push($i,  $requestFd );
            }
            var_dump($requestFd);
        });

        $server->start();
    }
}
