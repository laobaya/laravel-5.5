<!DOCTYPE html>
<html>
  
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
        <a href="">权限管理</a>
        <a>
          <cite>导航元素88</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加规则','rule/create')"><i class="layui-icon"></i>添加</button>
        <!-- <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button> -->
        <span class="x-right" style="line-height:40px">共有数据：{{$rules->total()}} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>权限规则</th>
            <th>权限名称</th>
            <th>所属分类</th>
            <th>操作</th>
        </thead>
        <tbody>
          @foreach($rules as $k=>$v)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v['id']}}'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$k+1}}</td>
            <td>{{$v['rule']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['menu']}}</td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','rule/{{$v['id']}}/edit')" href="javascript:;">
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
        {{$rules->links()}}
      </div>

    </div>
    <script>
      
      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              var url = 'rule/'+id;
              $.post(url,{'_token':"{{ csrf_token() }}","_method":"DELETE"},function(m){
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