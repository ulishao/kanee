<?php

class WebServer
{
    private $list;

    public function __construct()
    {
        $this->list=[];
    }

    public function worker( $request )
    {

//        $pid = pcntl_fork();

//        if ($pid == -1) {
//
//            die('could not fork');
//        } else if ($pid) {
//            //父进程会得到子进程号，所以这里是父进程执行的逻辑
//            pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
//        } else {
//            //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
//        }
        $pid=pcntl_fork ();
        //父进程和子进程都会执行下面代码

        //错误处理：创建子进程失败时返回-1.
        if ( $pid == -1 ) {
            return false;
        }
        if ( $pid > 0 ) {
            return $pid;
        }
        if ( $pid == 0 ) {
            $time  =$request[ 0 ];
            $method=$request[ 1 ];
            $start =microtime (true);
            echo getmypid () . "\t start " . $method . "\tat" . $start . PHP_EOL;
//sleep($time);
            $c=file_get_contents ($method);
            echo getmypid () . "\n";
            $end =microtime (true);
            $cost=$end - $start;
            echo getmypid () . "\t stop \t" . $method . "\tat:" . $end . "\tcost:" . $cost . PHP_EOL;
            exit(0);
        }
    }

    public function master( $requests )
    {
        $start=microtime (true);
        echo "All request handle start at " . $start . PHP_EOL;
        foreach ($requests as $request) {
            $pid=$this->worker ($request);
            if ( !$pid ) {
                echo 'handle fail!' . PHP_EOL;
                return;
            }
            array_push ($this->list , $pid);
        }
        while (count ($this->list) > 0) {
            foreach ($this->list as $k=>$pid) {
                $res=pcntl_waitpid ($pid , $status , WNOHANG);
                if ( $res == -1 || $res > 0 ) {
                    unset($this->list[ $k ]);
                }
            }
            usleep (100);
        }
        $end =microtime (true);
        $cost=$end - $start;
        echo "All request handle stop at " . $end . "\t cost:" . $cost . PHP_EOL;
    }
}

$requests=[
    [ 1 , 'http://www.sina.com' ] ,
    [ 2 , 'http://www.sina.com' ] ,
    [ 3 , 'http://www.sina.com' ] ,
    [ 4 , 'http://www.sina.com' ] ,
    [ 5 , 'http://www.sina.com' ] ,
    [ 6 , 'http://www.sina.com' ],
];

echo "多进程测试：" . PHP_EOL;
$server=new WebServer();
$server->master ($requests);

