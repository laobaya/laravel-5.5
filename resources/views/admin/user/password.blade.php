<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME')}}</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/xadmin.css">
    <script type="text/javascript" src="/static/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/js/xadmin.js"></script>
    <script type="text/javascript" src="/static/js/cookie.js"></script>
    <!-- <script>
      // 是否开启刷新记忆tab功能
      var is_remember = false;
  </script> -->
</head>

<body>
    <div class="x-body">
        <form class="layui-form">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    昵称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" disabled="" value="{{$user['name']}}" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_oldpass" class="layui-form-label">
                    <span class="x-red">*</span>旧密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_oldpass" name="oldpassword" required="" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>新密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="newpassword" required="" lay-verify="pass" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repassword" required="" lay-verify="repass" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="save" lay-submit="">
                    确认修改
                </button>
            </div>
        </form>
    </div>
    <script>
      layui.use(['form', 'layer'], function() {
          $ = layui.jquery;
          var form = layui.form,
              layer = layui.layer;

          //自定义验证规则
          form.verify({
              pass: [/(.+){6,12}$/, '密码必须6到12位'],
              repass: function(value) {
                  if ($('#L_pass').val() != $('#L_repass').val()) {
                      return '两次密码不一致';
                  }
              }
          });

          //监听提交
          form.on('submit(save)', function(data) {
              $.post(' ', data.field, function(m) {
                  if (m.res == 0) {
                      layer.alert(m.msg, { icon: 6 }, function() {
                          // 获得frame索引
                          var index = parent.layer.getFrameIndex(window.name);
                          //关闭当前frame
                          parent.layer.close(index);
                      });
                  } else {
                      layer.msg(m.msg, { icon: 5, time: 1000 });
                  }

              })
              return false;
          });


      });
    </script>
</body>

</html>