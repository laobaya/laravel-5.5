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
        <a href="../../welcome">首页</a>
        <a href="">产品库存详情</a>
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
          <div class="layui-input-inline">
            <select name="type">
              <option value="">展示类型</option>
              <option value="y">按年展示</option>
              <option value="m">按月展示</option>
              <option value="d">按天展示</option>
            </select>
          </div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <table class="layui-table" lay-data="{url:'./info?data=true',page:true,id:'test'}" lay-filter="testDemo">
        <thead>

          <tr>
            <th lay-data="{type:'checkbox',fixed:'left'}">ID</th>
            <th lay-data="{field:'id',sort:true}">ID</th>
            <th lay-data="{field:'name'}">产品</th>
            <th lay-data="{field:'date'}">发生日期</th>
            <th lay-data="{field:'number',templet:'#numberTpl'}">发生数量(增###减)</th>
            <th lay-data="{field:'type'}">类型</th>
            <th lay-data="{fixed: 'right',width:220, align:'center', toolbar: '#barTpl'}">操作</th>
        </thead>
      </table>

    </div>
    <script type="text/html" id="numberTpl">
      <!-- 设置状态模板 -->
      +@{{d.number.ru}} -@{{d.number.cu}}
    </script>
    <script type="text/html" id="barTpl">
      <a class="layui-btn layui-btn-normal" lay-event="show">查看详情</a>
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
      // $ = layui.$;
      var table = layui.table,form = layui.form;
      
      //监听单元格编辑
      /*table.on('edit(testDemo)', function(obj){
        var value = obj.value //得到修改后的值
        ,data = obj.data //得到所在行所有键值
        ,field = obj.field; //得到字段
        layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
      });*/

      // 定义公共方法
      // 定义重载页面方法
      function reloadView(where=''){
        table.reload('test', {
            url: 'info?data=true'
            ,where: {where} //设定异步数据接口的额外参数
          });
      }
      function extractId(obj,length){
        var id = '';
        obj.forEach(function(element,index){
          
            if(++index == length){
             id += element.id;  
            }else{
             id += element.id+',';  
            }
         });

        return id;
      }


      //监听行工具事件
      table.on('tool(testDemo)', function(obj){

        var data = obj.data;

        // 判断事件进行监听
        switch(obj.event){
          case 'show':
            x_admin_show('查看详情','info/'+data.date);
          break;
        }        
      });


      form.on('submit(sreach)', function(data){

        reloadView(data.field);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
      });
    });
    </script>
    
  </body>

</html>