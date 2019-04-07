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
  
  <body class="">
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
        <div class="layui-btn" onclick="x_admin_show('添加库存类型','operation/add',500,230)"><i class="layui-icon"></i>添加库存类型</div>
      </div>
      <table class="layui-table" lay-data="{url:'operation?data=true',page:true,id:'test'}" lay-filter="testDemo">
        <thead>
          <tr>
            <th lay-data="{type:'checkbox'}">ID</th>
            <th lay-data="{field:'id', sort: true}">ID</th>
            <th lay-data="{field:'name'}">库存类型名</th>
            <th lay-data="{field:'operation',templet:'#operationTpl'}">运算</th>
            <th lay-data="{field:'created_at', sort: true}">创建时间</th>
            <th lay-data="{fixed: 'right',width:220, align:'center', toolbar: '#barTpl'}">操作</th>

          </tr>
        </thead>
      </table>

    </div>
    <script type="text/html" id="operationTpl">
      <!-- 设置状态模板 -->
      <input type="checkbox" name="operation" value="@{{d.operation}}" lay-skin="switch" lay-text="增|减" lay-filter="stateDemo" data-id="@{{ d.id }}" @{{ d.operation == '+' ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="barTpl">
      <a class="layui-btn layui-btn-xs" lay-event="edit">修改</a>
      <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
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
    </script>
    <script>
    layui.use(['table','form'], function(){

      var table = layui.table,form = layui.form;
      
      //监听行工具事件
      table.on('tool(testDemo)', function(obj){

        var data = obj.data;

        // 判断事件进行监听
        switch(obj.event){
          case 'del'://删除行
            layer.confirm('真的删除行么', function(index){
              $.post(' ',{'id':data.id,'_token':"{{ csrf_token() }}",'_method':'DELETE'},function(msg){
                  // console.log(m);
                  if(msg.res == 0){
                    obj.del();
                    layer.close(index);
                  }
                  layer.msg(msg.msg);
              });
            });
          break;
          case 'edit':
            layer.prompt({
              formType: 2
              ,title:'库存类型名'
              ,value: data.name,
            }, function(value,index){
              
              data.name = value;
              delete(data['operation']);

              $.post('',{'id':data.id,'data':data,'_token':"{{csrf_token()}}"},function(datas){
                if(datas.res == 0){
                  obj.update(data);
                  layer.close(index);
                }
                layer.msg(datas.msg);
              });

          });
          break;
        }
        
      });

      // 复选框事件
      form.on('switch(stateDemo)', function(obj){
        // 切换状态
        var id = $(this).attr('data-id');

        $.post('',{'id':id,'val':obj.value,'_token':"{{csrf_token()}}",'_method':'PUT'},function(data){
              if(data.res == 0){
                $(this).attr('value',data.val);
              }
              layer.msg(data.msg);
        });

      });



    });
    </script>
    
  </body>

</html>