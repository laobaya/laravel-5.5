<!DOCTYPE html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>{{env('APP_NAME')}}</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="/static/css/font.css">
  <link rel="stylesheet" href="/static/css/xadmin.css">
  <script type="text/javascript" src="/static/jquery/3.2.1/jquery.min.js"></script>
  <script src="/static/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/static/js/xadmin.js"></script>
  <script type="text/javascript" src="/static/js/cookie.js"></script>
  <!-- <script>
      // 是否开启刷新记忆tab功能
      var is_remember = false;
  </script> -->
</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="{{route('admin')}}">{{env('APP_NAME')}}</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+库存功能</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('库存详情','inventory')"><i class="iconfont">&#xe6a2;</i>库存详情</a></dd>
            </dl>
          </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">{{\Auth::user()['name']}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('修改密码','user/changepassword',550,400)">修改密码</a></dd>
              <dd><a href="user/resetpassword">重置密码</a></dd>
              <dd><a href="logout">退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="{{url('/')}}">前台首页</a></li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    @include('admin.left')
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
          </div>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
          <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2019 顾森健康 All Rights Reserved</div>  
    </div>
    <!-- 底部结束 -->
    
</body>
</html>