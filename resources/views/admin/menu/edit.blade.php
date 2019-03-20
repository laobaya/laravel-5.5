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
    <div class="x-body">
        <form class="layui-form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="layui-form-item">
              <label class="layui-form-label">所属菜单</label>

              <div class="layui-input-inline">
                  <select class="layui-select" name="pid">
                      <option value="0">顶级菜单</option>
                      @foreach($topmenu as $w)
                      <option value={{$w['id']}} 
                      {{ ($w['id'] == $menu['pid']) ? "selected" :"" }}
                      >{{$w['name']}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="layui-form-item">  
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="name" name="name" value="{{$menu['name']}}" lay-verify="required"
                  autocomplete="off" value="" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>
              </div>
          </div>
          
          <div class="layui-form-item">  
              <label for="username" class="layui-form-label">
                  <span class="x-red"></span>路径
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="href" name="href" value="{{$menu['href']}}" 
                  autocomplete="off" class="layui-input">
              </div>
              
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
              </button>
          </div>
      </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
          });

          //监听提交
          form.on('submit(add)', function(data){

            //console.log(data);
            //发异步，把数据提交给php
            var url = " ";
            $.post(url,data.field,function(m){
                if(m.res==0){
                  layer.alert(m.msg, {icon: 6},function () {
                      // 获得frame索引
                      var index = parent.layer.getFrameIndex(window.name);
                      //关闭当前frame
                      parent.layer.close(index);
                      parent.location.reload();
                      //window.opener.location.reload();
                  });
                }else{
                  layer.msg(m.msg,{icon: 5,time:1000});
                }

            })
  
            return false;
          });
          
          
        });
    </script>
     
  </body>

</html>