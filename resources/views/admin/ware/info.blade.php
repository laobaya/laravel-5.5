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
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
          <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
          <input type="text" name="name"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <table class="layui-table" lay-data="{url:'./info?data=true',page:true,toolbar: '#toolbarDemo',id:'test'}" lay-filter="test">
        <thead>

          <tr>
            <th lay-data="{type:'checkbox'}">ID</th>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'product', minWidth: 100}">产品</th>
            <th lay-data="{field:'created_at', width:160, sort: true}">创建时间</th>
            <th lay-data="{field:'order_number', edit: 'text', minWidth: 150}">单号</th>
            <th lay-data="{field:'state','event':'state', width:150,templet: '#switchTpl'}">状态</th>
            <th lay-data="{field:'number', edit: 'int', minWidth: 100}">数量</th>
            <th lay-data="{field:'remark', edit: 'text'}">备注</th>
          </tr>
        </thead>
      </table>

    </div>
    <script type="text/html" id="toolbarDemo">
      <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="add">添加</button>
        <button class="layui-btn layui-btn-sm" lay-event="del">删除</button>
        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
      </div>
    </script>
    <script type="text/html" id="switchTpl">
      <!-- 设置状态模板 -->
      <input type="checkbox" name="state" value="@{{d.state}}" lay-skin="switch" lay-text="审核通过|审核中" lay-filter="stateDemo" @{{ d.state == 0 ? 'checked' : '' }}>
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
    layui.use('table', function(){
      var table = layui.table;
      
      //监听单元格编辑
      table.on('edit(test)', function(obj){
        var value = obj.value //得到修改后的值
        ,data = obj.data //得到所在行所有键值
        ,field = obj.field; //得到字段
        layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
      });

      //头工具栏事件
      table.on('toolbar(test)', function(obj){
        
        var checkStatus = table.checkStatus(obj.config.id);
        console.log(obj.config.index);
        console.log(checkStatus);
        switch(obj.event){
          case 'add':// 添加
            layer.open({
              type: 2, 
              skin: 'layui-layer-rim', //加上边框
              area: ['600px','600px'], //宽高
              content: 'info/add'  
              //content: 'info/add' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
            });
          break;
          case 'del'://删除
            var data = checkStatus.data;

            if(data.length != 1){
              layer.msg('请选择1个进行删除！');
            }else{
              
              $.post(' ',{'id':data[0].id,'_token':"{{ csrf_token() }}",'_method':'DELETE'},function(msg){
                  // console.log(m);
                  if(msg.res == 1){
                    $("tr[data-index='" + 1 + "']").remove();
                  }
                  layer.msg(msg.msg);
              });
            }
          break;
          case 'getCheckData':
            var data = checkStatus.data;
            layer.alert(JSON.stringify(data));
          break;
          case 'getCheckLength':
            var data = checkStatus.data;
            layer.msg('选中了：'+ data.length + ' 个');
          break;
          case 'isAll':
            layer.msg(checkStatus.isAll ? '全选': '未全选');
          break;
        };
      });


      // 复选框事件
      table.on('checkbox(switchTpl)', function(obj){
        console.log(obj)
      });

    });
    </script>
    
  </body>

</html>