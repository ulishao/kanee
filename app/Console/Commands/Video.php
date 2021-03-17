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


class Video extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video';
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
        parent::__construct ();
    }

    public function handle ()
    {
        $this->compressVideo();
    }


    /* 视频压缩 */
    public function compressVideo() {
//        $file_content = file_get_contents($file);
//        $compress_path = PUBLIC_PATH;
//        $compress_file = $compress_path . $file_name . '.mp4';
//        $compress_after_file = $compress_path . $file_name . '_compress.mp4';
        $compress_file = 'C:\Users\shaowei\Desktop\video\1.mp4';
//        dd(1);
//        ffmpeg.exe -i 1.mp4 -b:v 1000k -s 960x540 2.mp4
        try{
//            file_put_contents($compress_file, $file_content);
//            $video_info;
//            exec('C:\Users\shaowei\Desktop\video\ffmpeg -i C:\Users\shaowei\Desktop\video\1.mp4 -s 960x540 C:\Users\shaowei\Desktop\video\3.mp4',$video_info,$return);
//            dd($video_info,$return);
            $this->videoUpload('http://vfx.mtime.cn/Video/2019/03/14/mp4/190314102306987969.mp4','13.mp4',600,0,0,'avi');
//            $video_info = implode(' ', $video_info);
//            if(preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $video_info, $match)) {
//                $bitrate = $match[3];
//            }
//            if(preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $video_info, $match)) {
//                $resolution = $match[3];
//            }
//            dd($bitrate,$resolution);
//            $bitrate = '';    // 比特率
//            $resolution = ''; // 分辨率
//            if(preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $video_info, $match)) {
//                $bitrate = $match[3];
//            }
//            if(preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $video_info, $match)) {
//                $resolution = $match[3];
//            }
//            $file_size = filesize($compress_file);
//            $file_size = intval($file_size / 1048576);
//            if(empty($bitrate)) throwErr('找不到比特率信息');
//            if(empty($resolution)) throwErr('找不到分辨率信息');
//
//            if($file_size < 10) throwErr('视频大小不足10M，不需要压缩', null, 1100);
//
//            $resolution = explode('x', $resolution);
//            $bitrate_update = '';
//            $resolution_width_update = '';
//            $resolution_height_update = '';
//            $bitrate_update = $this->getVideoCompressBitrate($bitrate);
//            $resolution_percent = 0;
//            if($resolution[0] > $resolution[1]) {
//                if($resolution[1] > 320) {
//                    $resolution_percent = $resolution[1] <= 520 ? 0.8 : 0.5;
//                }
//            }else {
//                if($resolution[0] > 320) {
//                    $resolution_percent = $resolution[0] <= 520 ? 0.8 : 0.5;
//                }
//            }
//            if($resolution_percent > 0) {
//                $resolution_width_update = intval($resolution[0] * $resolution_percent);
//                $resolution_height_update = intval($resolution[1] * $resolution_percent);
//            }
//            if(empty($bitrate_update) && empty($resolution_width_update)) throwErr('比特率和分辨率同时不满足压缩条件', null, 1100);
//
//            $compress_bitrate = '';
//            $compress_resolution = '';
//            if(!empty($bitrate_update)) {
//                $compress_bitrate = "-b:v {$bitrate_update}k";
//            }
//            if(!empty($resolution_width_update)) {
//                $compress_resolution = "-s {$resolution_width_update}x{$resolution_height_update}";
//            }
//            $compress_exec = FFMPEG_PATH . "ffmpeg -i {$compress_file} %s% %v% {$compress_after_file}";
//            $compress_exec = str_replace(array('%s%', '%v%'), array($compress_resolution, $compress_bitrate), $compress_exec);
//            exec($compress_exec);
//            unlink($compress_file);
//
//            return array('compress_file' => $compress_after_file);
        }catch(\Exception $e) {
          dd($e->getMessage());
        }
    }

    /**
     * 视频压缩
     * @param string $file  视频地址
     * @param string $file_name 压缩后视频名称
     * @param string $bitrate 压缩后码率
     * @param int $width 压缩后宽
     * @param int $height 压缩后高
     * @param string $format 压缩后格式
     * @access public videoUpload
     * @return array|string[]
     * @author admin
     */
    public function videoUpload(string $file,string $file_name,string $bitrate,int $width=0,int $height=0,$format='mp4')
    {
        $file_content = file_get_contents($file);
        $compress_path = public_path().'\/';
        $compress_file = $compress_path . $file_name . '.mp4';
        $compress_after_file = $compress_path . $file_name . '_compress.'.$format;
        try{
            file_put_contents($compress_file, $file_content);
            $bitrate_update = $bitrate; //码率
            $resolution_width_update = $width; //宽
            $resolution_height_update = $height; //高
            $compress_bitrate = ''; //码率
            $compress_resolution = '';  //
            if(!empty($bitrate_update)) {
                $compress_bitrate = "-b:v {$bitrate_update}k";
            }
            if(!empty($resolution_width_update) && !empty($resolution_height_update)) {
                $compress_resolution = "-s {$resolution_width_update}x{$resolution_height_update}";
            }
            dump($compress_resolution);
            $compress_exec = 'ffmpeg' ." -i {$compress_file} %s% %v% {$compress_after_file} ";
            $compress_exec = str_replace(array('%s%', '%v%'), array($compress_resolution, $compress_bitrate), $compress_exec);
            dump($compress_exec);
            exec($compress_exec);
//            unlink($compress_file);
            dump('ok');
            return array('compress_file' => $compress_after_file);
        }catch(\Exception $e) {
            unlink($compress_file);
            return array();
        }

    }
    public function compressVideo1($file, $file_name) {
        $file_content = file_get_contents($file);
        $compress_path = public_path().'\/';
        $compress_file = $compress_path . $file_name . '.mp4';
        $compress_after_file = $compress_path . $file_name . '_compress.mp4';
        dump($compress_file);
        try{
            file_put_contents($compress_file, $file_content);
//            $video_info;
            exec( 'C:\Users\shaowei\Desktop\video\ffmpeg' ." -i {$compress_file} 2>&1", $video_info);
            $video_info = implode(' ', $video_info);
            dump($video_info);
            $bitrate = '';    // 比特率
            $resolution = ''; // 分辨率
            if(preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $video_info, $match)) {
                $bitrate = $match[3];
            }
            if(preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $video_info, $match)) {
                $resolution = $match[3];
            }
            dump($bitrate,$resolution);
            $file_size = filesize($compress_file);
            $file_size = intval($file_size / 1048576);
            if(empty($bitrate)) {
                dump('找不到比特率信息');
                return;
            }
            if(empty($resolution)) {
                dump('找不到分辨率信息');
                return;
            }

//            if($file_size < 10){
//               dump('视频大小不足10M，不需要压缩');
//               return;
//            }

            $resolution = explode('x', $resolution);
            $bitrate_update = '';
            $resolution_width_update = '';
            $resolution_height_update = '';
            $bitrate_update = $this->getVideoCompressBitrate($bitrate);
            $resolution_percent = 0;
            if($resolution[0] > $resolution[1]) {
                if($resolution[1] > 320) {
                    $resolution_percent = $resolution[1] <= 520 ? 0.8 : 0.5;
                }
            }else {
                if($resolution[0] > 320) {
                    $resolution_percent = $resolution[0] <= 520 ? 0.8 : 0.5;
                }
            }
            if($resolution_percent > 0) {
                $resolution_width_update = intval($resolution[0] * $resolution_percent);
                $resolution_height_update = intval($resolution[1] * $resolution_percent);
            }
            if(empty($bitrate_update) && empty($resolution_width_update))
            {
//                throw new Exception('比特率和分辨率同时不满足压缩条件', null, 1100);
                dump('比特率和分辨率同时不满足压缩条件');
                return;
            }

            $bitrate_update = '100'; //码率
            $resolution_width_update = '200'; //宽
            $resolution_height_update = '200'; //高
            $compress_bitrate = ''; //码率
            $compress_resolution = '';  //
            if(!empty($bitrate_update)) {
                $compress_bitrate = "-b:v {$bitrate_update}k";
            }



            if(!empty($resolution_width_update)) {
                $compress_resolution = "-s {$resolution_width_update}x{$resolution_height_update}";
            }

            dump($compress_resolution);
            $compress_exec = 'C:\Users\shaowei\Desktop\video\ffmpeg' ." -i {$compress_file} %s% %v% {$compress_after_file}";
            $compress_exec = str_replace(array('%s%', '%v%'), array($compress_resolution, $compress_bitrate), $compress_exec);
            dump($compress_exec);
            exec($compress_exec);
            unlink($compress_file);
            dump('ok');
            return array('compress_file' => $compress_after_file);
        }catch(\Exception $e) {
            unlink($compress_file);
            return array();
        }
    }


    /* 获取视频压缩比特率 */
    public function getVideoCompressBitrate($bitrate, $query_count = 0) {
        $bitrate_update = '';
        if($bitrate >= 700) {
            if($bitrate <= 1000) {
                $bitrate_update = intval($bitrate * 0.8);
            }else {
                $bitrate_update = intval($bitrate * 0.5);
            }
        }
        if(empty($bitrate_update)) {
            return $query_count == 0 ? $bitrate_update : $bitrate;
        }else {
            return $this->getVideoCompressBitrate($bitrate_update, ++$query_count);
        }
    }

}
