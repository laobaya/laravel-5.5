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
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
          <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
          <div class="layui-input-inline">
            @php($typename = \App\Model\WareOperation::select('id','name')->get())

            <select name="type">
              <option value="">类型</option>
              
              @foreach($typename as $v)
              <option value="{{$v['id']}}">{{$v['name']}}</option>
              @endforeach

            </select>
          </div>
          <!-- <input type="text" name="phone"  placeholder="请输入手机号" autocomplete="off" class="layui-input"> -->
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button><div class="layui-btn" onclick="x_admin_show('添加类型','ware/type_add')"><i class="layui-icon"></i>添加类型</div>
        </form>
        <!-- 添加类型 -->

      </div>
      <table class="layui-table" lay-data="{url:'./ware?data=true',page:true,toolbar: '#toolbarDemo',id:'test'}" lay-filter="testDemo">
        <thead>

          <tr>
            <th lay-data="{type:'checkbox',fixed:'left'}">ID</th>
            <th lay-data="{field:'id',sort:true}">ID</th>
            <th lay-data="{field:'name',width:100}">操作名</th>
            <th lay-data="{field:'user',width:90}">创建管理员</th>
            <!-- <th lay-data="{field:'phone', edit: 'text'}">手机号</th> -->
            <th lay-data="{field:'created_at',sort: true,width:140}">创建时间</th>
            <th lay-data="{field:'state',width:80,templet:'#switchTpl'}">审核状态</th>
            <th lay-data="{field:'type_name'}">类型</th>
            <th lay-data="{field:'remark'}">备注</th>
            <th lay-data="{fixed: 'right',width:220, align:'center', toolbar: '#barTpl'}">操作</th>
          </tr>
        </thead>
      </table>

    </div>
    <script type="text/html" id="toolbarDemo">
      <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm" lay-event="add">添加</button>
        <button class="layui-btn  layui-btn-normal" lay-event="tongall">批量通过审核</button>
        <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="delall">批量删除</button>
      </div>
    </script>
    <script type="text/html" id="switchTpl">
      <!-- 设置状态模板 -->
      <input type="checkbox" name="state" value="@{{d.state}}" lay-skin="switch" lay-text="是|否" lay-filter="stateDemo" data-id="@{{ d.id }}" @{{ d.state == 0 ? 'checked' : '' }}>
    </script>

    <script type="text/html" id="barTpl">
      <a class="layui-btn layui-btn-xs" lay-event="edit">修改</a>
      <a class="layui-btn layui-btn-normal" lay-event="show">查看详情</a>
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
            url: 'ware?data=true'
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

      //头工具栏事件
      table.on('toolbar(testDemo)', function(obj){
        
        var checkStatus = table.checkStatus(obj.config.id);
        var data = checkStatus.data;//获取数据
        var dataLen = data.length;//获取数据的长度

        switch(obj.event){
          case 'add':// 添加
            x_admin_show('添加','ware/add');
          break;
          case 'delall'://删除
            var ids = extractId(data,dataLen);
            
            $.post('ware/alldel',{'id':ids,'_token':"{{ csrf_token() }}"},function(data){
                // console.log(m);
                layer.msg(data.msg);

                if(data.res == 0){
                   reloadView();
                }
                layer.msg(data.msg);
            });
            
          break;
          case 'tongall'://批量通过
            
            var ids = extractId(data,dataLen);
            $.post('ware/alltong',{'id':ids,'_token':"{{ csrf_token() }}"},function(data){
                // console.log(m);
                layer.msg(data.msg);

                if(data.res == 0){

                   reloadView();
                }
                layer.msg(data.msg);
            });
            
          break;
        };
      });

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
              ,title:'备注'
              ,value: data.remark,
            }, function(value,index){
              data.remark = value;
              $.post('',{'id':data.id,'data':data,'_token':"{{csrf_token()}}"},function(datas){
                if(datas.res == 0){
                  obj.update(data);
                  layer.close(index);
                }
                layer.msg(datas.msg);
              });

          });
          break;
          case 'show':
            x_admin_show('查看详情','ware/'+data.id+'/info')
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
        })
      });

      form.on('submit(sreach)', function(data){

        reloadView(data.field);
        //console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
        //console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
        //console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
      });
    });
    </script>
    
  </body>

</html>