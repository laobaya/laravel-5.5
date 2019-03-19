<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-{{session('adminBiaoti') ? session('adminBiaoti') : "x-admin"}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     
    <link rel="shortcut icon" href="{{asset('/')}}/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/xadmin.css">
    <script type="text/javascript" src="/static/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">后台菜单</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-form-pane">
          <input class="layui-input" placeholder="分类名" name="cate_name">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
        </form>
      </div>
      <!-- <blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote> -->
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        
      </xblock>
      <table class="layui-table layui-form">
        <thead>
          <tr>
            <th width="20">
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th width="70">ID</th>
            <th>栏目名</th>
            <th width="50">排序</th>
            <th width="50">状态</th>
            <th width="220">操作</th>
        </thead>
        <tbody class="x-cate">
          
          @foreach($menu as $v)
            
            <tr cate-id="{{$v['id']}}" fid="{{$v['pid']}}" >
              <td>
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id="{{$v['id']}}"><i class="layui-icon">&#xe605;</i></div>
              </td>
              <td>{{$v['id']}}</td>
              <td>&nbsp;&nbsp;<i class='layui-icon x-show' status='true'>&#xe623;</i>{!! $v['name'] !!}</td>
              <td><input type="text" class="layui-input x-show" name="order" value="{{$v['order']}}"></td>
              <td>
                <input type="checkbox" name="switch" class="state" lay-text="开启|停用"  @if($v['state']==0)checked=""@endif lay-skin="switch">
              </td>
              <td class="td-manage">
                <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','menu/{{$v['id']}}/edit')" ><i class="layui-icon">&#xe642;</i>编辑</button>
                @if($v['pid'] == 0)
                <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加子栏目','menu/{{$v['id']}}/add')" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>
                @endif
                <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$v['id']}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
              </td>
            </tr>
            @foreach($v['child'] as $val)

              <tr cate-id='{{$val['id']}}' fid='{{$val['pid']}}' >
                <td>
                  <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$val['id']}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$val['id']}}</td>
                <td>&nbsp;&nbsp;
                  {{str_repeat("&nbsp;",$val['level']*4)}}├{{$val['name']}}
                </td>
                <td><input type="text" class="layui-input x-sort" name="order" value="{{$val['order']}}"></td>
                <td>
                  <input type="checkbox" name="switch" class="state" lay-text="开启|停用"  @if($val['state']==0)checked=""@endif lay-skin="switch">
                </td>
                <td class="td-manage">
                  <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','menu/{{$val['id']}}/edit')" ><i class="layui-icon">&#xe642;</i>编辑</button>
                  @if($val['pid'] == 0)
                  <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加子栏目','menu/{{$val['id']}}/add')" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>
                  @endif
                  <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$val['id']}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                </td>
              </tr>

            @endforeach

          @endforeach

        </tbody>
      </table>
    </div>
    <style type="text/css">
      
    </style>
    <script>
      layui.use(['form'], function(){
        form = layui.form;
        
      });
      /*更改排序*/
      $('.x-sort').change(function(){
        var id = $(this).parent().parent().attr('cate-id');
        var order = $(this).val();
        var url = "{{ url('admin/menuorder') }}";
        $.post(url,{'_token':"{{ csrf_token() }}",'_method':'PUT','id':id,'order':order},function(){

        })
        // alert(id);
        // alert(1);
      })
      // 启用禁用
      $("td").on('click','.layui-unselect',function(){
          var res = $(this).prev().is(':checked');
          var id = $(this).parent().parent().attr('cate-id');
          var url = "{{ url('admin/menustate') }}";
          // alert(id);
          var state = 1;
          if(res){
            state = 0;
          }
          
          $.post(url,{'_token':"{{ csrf_token() }}",'_method':'PUT','id':id,'state':state},function(m){
            if(m.res == 0){
              layer.msg(m.msg,{icon: 6,time:1000});         
            }else{
              layer.msg(m.msg,{icon: 5,time:1000});
            }
          })
          // alert(1);
          // alert(res);
      })
      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              var url = "{{url('admin/menudel')}}"+"/"+id;
              $.post(url,{'_token':"{{ csrf_token() }}"},function(m){
                  if(m.res == 0){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                  }else{
                    layer.msg(m.msg,{icon:0,time:1000});

                  }
              })
              
          });
      }

      

      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？',function(index){
            //捉到所有被选中的，发异步进行删除
            var url = "{{url('admin/menudelall')}}";
            $.post(url,{'_token':"{{ csrf_token() }}",'all':data},function(m){
                  if(m.res == 0){
                    layer.msg('删除成功', {icon: 1});
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                  }else{
                    layer.msg(m.msg,{icon:0,time:1000});

                  }
              })
        });
      }
    </script>
     
  </body>

</html>