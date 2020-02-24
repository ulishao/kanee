<?php

namespace App\Http\Controllers;


use App\Models\Bizhi;
use App\Models\Img;
use App\Models\ImgLabel;
use App\Models\Like;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Redis;

class ImgController extends Controller
{
    public function user ()
    {
        return Like::where(['url' => \request()->get('url')])->with(['user'])->orderBy('created_at')->get();
    }
    public function index()
    {
        return Resource::collection (Img::when (\request ()->get ('category_id'), function ( $query ) {
            return $query->where (['category_id' => request ()->get ('category_id')]);
        })
            ->where ('source_url', 'like', '%2019%')
            ->when(\request ()->get ('serach'),function ( $q){
                $q->where('title','like','%'.\request ()->get ('serach').'%');
            }
            )->orderBydesc ( 'created_at' )
            ->paginate( 2 ) );
    }

    public function biget()
    {

        $data  = Bizhi::all ();
        $redis = app ('redis.connection');
        $redis->del ('bizhi_data');
        foreach ($data as $r => $as) {
            $redis->sadd ('bizhi_data' , $as);
        }
        dd ('success');
    }
    public function bizhi ()
    {
//        return [
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/26/65554b2bd91d4e3390032feca436de7e!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/26/fc9cd9f2c6674562a6e70014be8fed0a!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/26/3c1fbb706cee4e6fbc260b41e60aaac7!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/26/b13fb73389a840a78a971c5996aa0ed2!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/25/8bcfa369d2b642f59b69a38b9dbdae78!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/25/eda9af0fadf54066a5f1a8899be96480!1080x1920.jpeg' ,
//            ] ,
//            [
//                'url'=>'https://img2.woyaogexing.com/2019/06/22/9ec0b52d16e843b190250b3f50efdc00!1080x1920.jpeg' ,
//            ] ,
//        ];
        $redis= app ('redis.connection');
        $a = $redis->srandmember('bizhi_data', 10);
        foreach ($a as $key => $item) {
            $d[] = json_decode ($item , true);
        }
        return $d;
    }

    public function redis ()
    {
        $data = Img::where('imgs', 'like', '%2019%')->with('imgLabel')->get()->toArray();
        $redis = app('redis.connection');
        foreach ($data as $r => $as) {
            $redis->del('img_id_data:' . $as[ 'category_id' ]);
        }
////
        foreach ($data as $r => $as) {
            $redis->sadd('img_id_data:' . $as[ 'category_id' ], json_encode($as));
        }
//        $a = $redis->smembers('img_id:1');
//        $b = $redis->srandmember('img_id:2');
//        $ids = [1,2];
//        $dd = array_rand($ids,1);
//        $id= $redis->srandmember('img_id:'.$ids[ $dd ]);
//        return Img::where (['id' =>$id ])->with ('imgLabel')->select (['id', 'imgs', 'title'])->first ();
//        return array_rand($s,1);
//        dd($a);
    }

    public function sui ()
    {
        $datate = [
            "幸福就是，我喜欢你，偏偏你也喜欢我。" ,
                        "和你在一起，才是爱情该有的样子。" ,
                        "有些人不属于你，但遇见了也挺好。" ,
                        "既然不能付出真心，就别触动我的心。" ,
                        "一生太短暂，遇到喜欢的人就要认真喜欢。" ,
                        "总有人要错过你，你才能赶上最好的相遇。" ,
                        "如果这世界上有你爱的人，你就没法自由。" ,
                        "要么一生，要么陌生，有你也好，无你也罢。" ,
                        "爱在心里，开不了口，你在梦里，放不开手。" ,
                        "明天越来越少，昨天越来越多。" ,
                        "你不是我的世界我不是你的唯一。" ,
                        "梦不是为想象，而是让我们继续前往。" ,
                        "每个人，都有一个世界，安静而孤独。" ,
                        "珍惜身边每次相遇，珍惜身边每个人。" ,
                        "过去每分每秒，难道只证明情比纸薄。" ,
                        "其实，有时候无知也是开心的一种资本。" ,
                        "生活不会因为你是年少，就对你笑脸相待。" ,
                        "幸福是自己的，永远不要拿别人来做参照。" ,
                        "人总是珍惜未得到的，而遗忘了所拥有的。" ,
                        "成长是一条必走的路路上我们伤痛在所难免。" ,
                        "突如其来的脾气，大概是积攒了很久的委屈。" ,
                        "既然还在幸运的活着，当然要全力以赴的快乐。" ,
                        "有些事一旦决定交给时间，也就意味着放弃了。" ,
                        "总有一个人，一直住在心底，却消失在生活里。" ,
                        "你塞满我整个过去，却在我的未来永远地缺席。" ,
                        "多年后仍能让你心痛的，是当年轻易放下的真爱。" ,
                        "将你锁在心底，将记忆彻底记忆。" ,
                        "世界上最幸福的事就是专职爱你。" ,
                        "不用海枯石烂，只要你明天不离开。" ,
                        "幸福的地址，写满故事从前的遗憾。" ,
                        "不可遗失的留恋，只可肆意的思恋。" ,
                        "爱的最高境界是经得起平淡的流年。" ,
                        "我的偏执，是你永远读不懂的剧本。" ,
                        "相守，是因为你我已成为彼此的习惯。" ,
                        "这世界不大不小， 用来遇见你刚刚好。" ,
                        "爱情注定是一次酒驾，你也得从容驾驶。" ,
                        "爱一个人很难，放弃自己心爱的人更难。" ,
                        "爱情使人忘记时间，时间也使人忘记爱情。" ,
                        "有些话，说的人动动嘴，听的人却动了心。" ,
                        "那些最终会让你陷进去的，一开始总是美好。" ,
                        "我们可以忘记这世间一切，可爱情却是例外的。" ,
                        "爱情不是轰轰烈烈的誓言，而且简简单单的陪伴。" ,
                        "不要因为结束而哭泣，微笑吧，为你的曾经拥有。" ,
                        "既然你在我心中挥之不去，那就留在这里呆着把。" ,
                        "他让你红了眼眶，你却还笑着原谅，这就是爱情。" ,
                        "没有完全合适的两个人，只有互相迁就的两个人。" ,
                        "亲爱的，再美好的事物，也象征不出我有多爱你。" ,
                        "假期很好，除了思念。" ,
                        "流年无罪，相遇太美。" ,
                        "因为太在乎，所以受不起。" ,
                        "感情是靠缘分的，强求不来。" ,
                        "你转身的一瞬，我萧条的一生。" ,
                        "跟着你，在哪里，做什么，都好。" ,
                        "原来梦里也会心痛，能痛到醒来。" ,
                        "结局已经如此，原因已经不再重要了。" ,
                        "原来这个世界真的没有谁可以代替谁。" ,
                        "我喜欢你，这是我唯一也是最后的秘密。" ,
                        "这么多年了，你的眼光，还是一样的差。" ,
                        "幸福就是，我喜欢你，偏偏你也喜欢我。" ,
                        "因为没得到，所以显得格外好，这不是爱。",
        ];

        $ids = [1];
        if ( !empty(request()->get('ids')) ) {
            $ids = explode(",", request()->get('ids'));
            $ids = array_filter($ids);
        }
        $redis        = app('redis.connection');
        $dd           = array_rand($ids, 1);
        $data         = json_decode ($redis->srandmember ('img_id_data:' . $ids[ $dd ]) , true);
        $data[ 'te' ] = $datate[ array_rand ($datate , 1) ];
        return $data;
        //$return;
    }
    public function list ()
    {
        $ids = [3, 4];
        if ( !empty(request ()->get ('category_id')) ) {
            $ids = explode (",", request ()->get ('category_id'));
            $ids = array_filter ($ids);
//            $ids[] = 3;
        }
        if ( \request ()->get ('name') ) {
            $id = ImgLabel::where (['label' => \request ()->get ('name')])->pluck ('img_id')->toArray ();
            $query = Img::whereIn ('id', $id);
        } else {
            $redis = app('redis.connection');
            $dd = array_rand($ids, 1);
            $a = $redis->srandmember('img_id_data:' . $ids[ $dd ], 2);
//            foreach ($a as $key => $item) {
//                $redis->sadd('user:' . \request()->get('openid'), $item);
//            }
//
//            $a = $redis->smembers('user:' . \request()->get('openid'));
//            if ( count($a) <= 2 ) {
//                $redis->expire('user:' . \request()->get('openid'), 60);
//            }
            foreach ($a as $key => $item) {
                $d[] = json_decode($item, true);
            }

            return ['data' => $d];
        }
//        if(\request ()->get ('category_id'))

        $data = $query->orderBydesc ('created_at')
            ->paginate (2);
        return Resource::collection ($data);
    }

    public function show()
    {
        return Img::where( 'id' , \request()->get( 'id' ) )->first();
    }

    public function url( Request $request )
    {

        $http = new Client();
        $a    = $http->get( $request->get( 'url' ) )->getBody()->getContents();
        header ("content-type: image/jpeg; charset=UTF-8");
        //使用图片头输出浏览器
        echo $a;
        die();
    }

    public function sui1 ()
    {

        $ids = [1];
        if(!empty(request ()->get ('ids'))){
            $ids = explode (",",request ()->get ('ids'));
            $ids = array_filter  ($ids);
        }
        $data = Img::whereIn ('category_id', $ids)->where ('imgs', 'like', '%2019%')->pluck ('id')->toArray ();
        $a        = array_rand( $data , 1 );
        return Img::where(['id' => $data[ $a ]])->with('imgLabel')->select(['id', 'imgs', 'title'])->first();
        //$return;
    }

    public function getaa()
    {

    }
}
