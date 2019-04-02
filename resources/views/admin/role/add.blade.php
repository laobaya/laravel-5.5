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
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tr><td>菜单</td><td>权限</td></tr>
                        <tbody>
                            @if(isset($menu))
                            @foreach($menu as $v)
                            <tr>
                                <td>
                                    <input type="checkbox" name="menu[]" lay-skin="primary" value="{{$v['id']}}" title="{{$v['name']}}">
                                </td>
                                
                                <td>
                                    <div class="layui-input-block">
                                    @foreach($rule_class as $w)
                                    
                                    @if($v['id'] == $w['menu_id'])
                                        <input name="rule[]" lay-skin="primary" type="checkbox" title="{{$w['name']}}" value="{{$w['id']}}"> 
                                    @endif
                                    @endforeach
                                </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            <!-- <tr>
                                <td>
                                   
                                    <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章管理">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章添加"> 
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章删除"> 
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章修改"> 
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章改密"> 
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章列表"> 
                                    </div>
                                </td>

                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="account" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
            </form>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          

          //监听提交
          form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.post(" ",data.field,function(m){
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