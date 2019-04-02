<!DOCTYPE html>
<html>
  
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
        <a href="">角色管理</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加用户','role/add')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{count($role)+1}}条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header  layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>角色名</th>
            <th>描述</th>
            <th>状态</th>
            <th>操作</th>
        </thead>

        <tbody>
          <tr>
            <td>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>1</td>
            <td>超级管理员</td>
            <td>具有至高无上的权利</td>
            <td class="td-status">
              <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
            <td class="td-manage">
              无法操作
            </td>
          </tr>
          @foreach($role as $q=>$w)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id="{{$w['id']}}"><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$q+2}}</td>
            <td>{{$w['name']}}</td>
            <td>{{$w['account']}}</td>
            <td class="td-status">
              @if($w['state'] == 0)
              <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
              @else
              <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
              @endif
            </td>
            <td class="td-manage">
              @if($w['state'] != 0)
              <a onclick="member_stop(this,'{{$w['id']}}')" href="javascript:;"  title="启用">
                <i class="layui-icon">&#xe601;</i>
              </a>
              @else
              <a onclick="member_stop(this,'{{$w['id']}}')" href="javascript:;"  title="禁用">
                <i class="layui-icon">&#xe62f;</i>
              </a>
              @endif
              <a title="编辑"  onclick="x_admin_show('编辑','role/{{$w['id']}}/edit')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <script>
      
      function member_stop(obj,id){
          layer.confirm('确认要切换吗？',function(index){
              if($(obj).attr('title')=='启用'){
                
                $.post("{{url('role/state')}}",{'_token':"{{ csrf_token() }}",'id':id,'state':0},function(m){
                  if(m.res != 0){
                    layer.msg(m.msg,{icon: 5,time:1000});
                    return false;
                }

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');
                
                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                
                layer.msg('已启用!',{icon: 6,time:1000});
                });
                

              }else{
                $.post("{{url('role/state')}}",{'_token':"{{ csrf_token() }}",'id':id,'state':1},function(m){
                  if(m.res != 0){
                    layer.msg(m.msg,{icon: 5,time:1000});
                    return false;
                }
                  $(obj).attr('title','启用');
                  $(obj).find('i').html('&#xe601;');

                  $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                  layer.msg('已停用!',{icon: 6,time:1000});
                });
               
              }
              
          });
      }

    </script>
     
  </body>

</html>