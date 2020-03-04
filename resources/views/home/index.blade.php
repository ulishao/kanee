<html>
<head>
    <title>红蓝cp-交友</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">图标</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">广场 <span class="sr-only">(current)</span></a></li>
                <li><a href="#">附近动态</a></li>
                {{--                <li class="dropdown">--}}
                {{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
                {{--                    <ul class="dropdown-menu">--}}
                {{--                        <li><a href="#">Action</a></li>--}}
                {{--                        <li><a href="#">Another action</a></li>--}}
                {{--                        <li><a href="#">Something else here</a></li>--}}
                {{--                        <li role="separator" class="divider"></li>--}}
                {{--                        <li><a href="#">Separated link</a></li>--}}
                {{--                        <li role="separator" class="divider"></li>--}}
                {{--                        <li><a href="#">One more separated link</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="爱好">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">登录</a></li>
                {{--                <li class="dropdown">--}}
                {{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
                {{--                    <ul class="dropdown-menu">--}}
                {{--                        <li><a href="#">Action</a></li>--}}
                {{--                        <li><a href="#">Another action</a></li>--}}
                {{--                        <li><a href="#">Something else here</a></li>--}}
                {{--                        <li role="separator" class="divider"></li>--}}
                {{--                        <li><a href="#">Separated link</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="" style="text-align: center">
    <div class="container" style="width: 800px;background-color:grey">
        <div class="thumbnail">
            <img width=200 height=200
                 src="https://kanee-img.cn-bj.ufileos.com/static/e4882315-660b-ce70-953e-acc4784f348c.jpg" alt="...">
            <div class="caption">
                <h3>咋的了小伙子</h3>
                <p>在线中</p>
                {{--                <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>--}}
            </div>
        </div>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">立即聊天</a><a class="btn btn-primary btn-lg" href="#"
                                                                               role="button">切换</a></p>
    </div>
</div>


{{--<div class="panel panel-default">--}}
{{--    <div class="panel-heading">--}}
{{--        <h3 class="panel-title">一周cp推荐</h3>--}}
{{--    </div>--}}
{{--    <div class="panel-body">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="thumbnail">--}}
{{--                    <img width=200 src="https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1273653629,1660702170&fm=26&gp=0.jpg" alt="...">--}}
{{--                    <div class="caption">--}}
{{--                        <h3>Thumbnail label</h3>--}}
{{--                        <p>...</p>--}}
{{--                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="thumbnail">--}}
{{--                    <img width=200 src="https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1273653629,1660702170&fm=26&gp=0.jpg" alt="...">--}}
{{--                    <div class="caption">--}}
{{--                        <h3>Thumbnail label</h3>--}}
{{--                        <p>...</p>--}}
{{--                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="thumbnail">--}}
{{--                    <img width=200 src="https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1273653629,1660702170&fm=26&gp=0.jpg" alt="...">--}}
{{--                    <div class="caption">--}}
{{--                        <h3>Thumbnail label</h3>--}}
{{--                        <p>...</p>--}}
{{--                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="thumbnail">--}}
{{--                    <img width=200 src="https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1273653629,1660702170&fm=26&gp=0.jpg" alt="...">--}}
{{--                    <div class="caption">--}}
{{--                        <h3>Thumbnail label</h3>--}}
{{--                        <p>...</p>--}}
{{--                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}
</body>
</html>