<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME')}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="{{asset('/')}}/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/xadmin.css">
    <script type="text/javascript" src="/static/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/js/xadmin.js"></script>
    <script type="text/javascript" src="/static/js/cookie.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="/static/compatible/html5.min.js"></script>
      <script src="/static/compatible/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
                <cite>导航元素</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      @if(count($data))
        <div class="layui-tab">
            <ul class="layui-tab-title">
                @foreach($data as $k => $v)
                @if($k == 0)
                <li class="layui-this">
                    @else
                <li>
                    @endif
                    {{$v['key']}}</li>
                @endforeach
                <li>当前剩余</li>
            </ul>
            <div class="layui-tab-content">
                @foreach($data as $k => $v)
                @if($k == 0)
                <div class="layui-tab-item layui-show">
                @else
                <div class="layui-tab-item">
                @endif
                  <table class="layui-table">
                      <thead>
                          <tr>
                              <th>产品</th>
                              <th>累计</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($v['value'] as $vo)
                          <tr>
                              <td>{{$vo['product']}}</td>
                              <td>{{$vo['sum']}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <thead>
                          <tr>
                              <th>产品</th>
                              <th>日期</th>
                              <th>累计</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($v['data'] as $vo)
                          <tr>
                              <td>{{$vo['product']}}</td>
                              <td>{{$vo['date']}}</td>
                              <td>{{$vo['sum']}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  @endforeach
                  <div class="layui-tab-item">
                  <table class="layui-table">

                    <thead>
                          <tr>
                              <th>产品</th>
                              <th>库存剩余</th>
                          </tr>
                      </thead>
                      <?php 

                      foreach ($data as $value) {

                          foreach ($value['value'] as $k => $val) {
                              $arr[$k]['jisuan'][] = $value['operation'].$val['sum'];
                              $arr[$k]['name'] = $val['product'];
                          }
                      }
                      // dump($arr);
                       ?>
                      <tbody>
                        @foreach($arr as $v)
                          <tr>
                              <td>{{$v['name']}}</td>
                              <td>{{array_sum($v['jisuan'])}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      </table>
                  </div>

                </div>
            </div>
        </div>
      @else
      <h1>暂无库存</h1>
      @endif
        <script>
        layui.use('laydate', function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        
        </script>
</body>

</html>