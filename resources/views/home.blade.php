<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>数据</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.min.css">

</head>
<body>
<div class="page-group">
    <div class="page page-current">
        <header class="bar bar-nav">
            <h1 class='title'>用户数据({{$count}})条</h1>
        </header>
        <div class="bar bar-header-secondary">
            <div class="searchbar">
                <a class="searchbar-cancel">取消</a>
                <div class="search-input">
                    <label class="icon icon-search" for="search"></label>
                    <input type="search" id='search' value="@if($name){{$name}} @endif" placeholder='输入关键字...'/>
                </div>


            </div>


        </div>

        <div class="content">
            @foreach($d as $key)
                <div class="content-block-title">{{$key->uuid}}</div>
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-media"><i class="icon icon-f7"></i></div>
                            <div class="item-inner">
                                <div class="item-title">姓名</div>
                                <div class="item-after">{{$key->name}}</div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-media"><i class="icon icon-f7"></i></div>
                            <div class="item-inner">
                                <div class="item-title">手机号</div>
                                <div class="item-after">{{$key->phone}}</div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-media"><i class="icon icon-f7"></i></div>
                            <div class="item-inner">
                                <div class="item-title">住址街路巷代码</div>
                                <div class="item-after">{{$key->address}}</div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-media"><i class="icon icon-f7"></i></div>
                            <div class="item-inner">
                                <div class="item-title">住址幢楼号</div>
                                <div class="item-after">{{$key->dong}}</div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-media"><i class="icon icon-f7"></i></div>
                            <div class="item-inner">
                                <div class="item-title">住址小区代码</div>
                                <div class="item-after">{{$key->code}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            @endforeach

        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/zepto/1.0rc1/zepto.min.js"></script>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
<script>
    $("#search").keydown(function () {
        if (event.keyCode == 13) {
            window.location.href = 'http://swoole.kanee.top/home?name=' + $(this).val()
        }
    })
</script>
</body>
</html>