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
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
          <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
          <input type="text" name="name"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <span class="x-right" style="line-height:40px">共有数据：{{$user->total()}} 条</span>
      </xblock>
      <table class="layui-table x-admin">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <!-- <th>性别</th>
            <th>手机</th> -->
            <th>邮箱</th>
            <!-- <th>地址</th> -->
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
          @foreach($user as $v)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <!-- <td>男</td>
            <td>13000000000</td> -->
            <td>{{$v['email']}}</td>
            <!-- <td>北京市 海淀区</td> -->
            <td>{{$v['created_at']}}</td>
            <td class="td-status">
              @if($v['state'] == 0)
              <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
              @else
              <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
              @endif
            </td>
            <td class="td-manage">
              @if($v['state'] != 0)
              <a onclick="member_stop(this,'{{$v['id']}}')" href="javascript:;"  title="启用">
                <i class="layui-icon">&#xe601;</i>
              </a>
              @else
              <a onclick="member_stop(this,'{{$v['id']}}')" href="javascript:;"  title="禁用">
                <i class="layui-icon">&#xe62f;</i>
              </a>
              @endif
              <a title="编辑"  onclick="member_edit(this,'{{$v['id']}}')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a onclick="x_admin_show('分配角色','user/{{$v['id']}}/role',550,300)" title="分配角色" href="javascript:;">
                <i class="layui-icon">&#xe631;</i>
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
        {{$user->links()}}
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
      function member_edit(obj,id){
          // console.log(obj);
          layer.prompt({
            formType: 0,
            value: '',
            title: '修改用户名'
          }, function(value, index, elem){
            // console.log(index);
            //alert(value); //得到value
            var url = 'user/'+id+'/edit';
            $.post(url,{'_token':"{{ csrf_token() }}",'name':value},function(data){
              // console.log(data);
              if(data.res == 0){
                layer.msg(data.msg,{icon: 6,time:1000});         
              }else{
                layer.msg(data.msg,{icon: 5,time:1000});
              }
            })
            layer.close(index);
          });
      }
      


      // 切换状态
      function member_stop(obj,id){
          layer.confirm('确认要切换吗？',function(index){
              if($(obj).attr('title')=='启用'){
                
                $.post("{{url('user/state')}}",{'_token':"{{ csrf_token() }}",'id':id,'state':0},function(m){
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
                $.post("{{url('user/state')}}",{'_token':"{{ csrf_token() }}",'id':id,'state':1},function(m){
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