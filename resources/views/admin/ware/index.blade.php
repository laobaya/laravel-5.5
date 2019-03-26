<!DOCTYPE html>
<html class="x-admin-sm">
  
  <head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.1</title>
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
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <div class="layui-input-inline">
            <select name="contrller">
              <option>支付状态</option>
              <option>已支付</option>
              <option>未支付</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="contrller">
              <option>支付方式</option>
              <option>支付宝</option>
              <option>微信</option>
              <option>货到付款</option>
            </select>
          </div>
          <div class="layui-input-inline">
            <select name="contrller">
              <option value="">订单状态</option>
              <option value="0">待确认</option>
              <option value="1">已确认</option>
              <option value="2">已收货</option>
              <option value="3">已取消</option>
              <option value="4">已完成</option>
              <option value="5">已作废</option>
            </select>
          </div>
          <input type="text" name="username"  placeholder="请输入订单号" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加订单','ware/add')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$ware->total()}} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>操作名</th>
            <th>手机号</th>
            <th>创建管理员</th>
            <th>状态</th>
            <th>类型</th>
            <th>创建时间</th>
            <th>备注</th>
            <th >操作</th>
            </tr>
        </thead>
        <tbody>
          @foreach($ware as $v)  
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id="{{$v['id']}}"><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['phone']}}</td>
            <td>{{$v['user']}}</td>
            <td>{{$v['state']}}</td>
            <td>{{$v['type_name']}}</td>
            <td>{{$v['created_at']}}</td>
            <td>{{$v['remark']}}</td>
            <td class="td-manage">
              <a title="查看"  onclick="x_admin_show('查看详情','ware/{{$v['id']}}/info')" href="javascript:;">
                <i class="layui-icon">&#xe63c;</i>
              </a>
              <a title="编辑"  onclick="x_admin_show('修改订单','ware/{{$v['id']}}/edit')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,'{{$v['id']}}')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="page">
        {!!$ware->links()!!}
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
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

      /*删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              var url = "ware/"+id;
              $.post(url,{'_token':"{{ csrf_token() }}",'_method':'DELETE'},function(m){
                  if(m.res == 0){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                  }else{
                    layer.msg(m.msg,{icon:0,time:1000});

                  }
              })
              
          });
      }
      
    </script>
    
  </body>

</html>