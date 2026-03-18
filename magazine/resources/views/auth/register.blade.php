<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册 - Magazine</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            width: 450px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }
        .register-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }
        .layui-form-item {
            margin-bottom: 20px;
        }
        .layui-form-item .layui-input {
            height: 45px;
            line-height: 45px;
            border-radius: 5px;
        }
        .submit-btn {
            width: 100%;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .submit-btn:hover {
            opacity: 0.9;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-msg {
            color: #ff5722;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="register-title">用户注册</h2>
        
        @if(session('success'))
            <div class="layui-bg-green" style="padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #fff;">
                {{ session('success') }}
            </div>
        @endif

        <form class="layui-form" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                <div class="layui-input-block">
                    <input type="text" name="name" lay-verify="required" placeholder="请输入用户名" 
                           autocomplete="off" class="layui-input" value="{{ old('name') }}">
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-email"></i></label>
                <div class="layui-input-block">
                    <input type="email" name="email" lay-verify="required|email" placeholder="请输入邮箱" 
                           autocomplete="off" class="layui-input" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                <div class="layui-input-block">
                    <input type="password" name="password" lay-verify="required|pass" placeholder="请输入密码" 
                           autocomplete="off" class="layui-input">
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                <div class="layui-input-block">
                    <input type="password" name="password_confirmation" lay-verify="required" 
                           placeholder="请确认密码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn submit-btn" lay-submit lay-filter="registerForm">
                        立即注册
                    </button>
                </div>
            </div>

            <div class="login-link">
                已有账号？<a href="{{ route('login') }}">立即登录</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('layui/layui.js') }}"></script>
    <script>
        layui.use(['form', 'layer'], function(){
            var form = layui.form;
            var layer = layui.layer;

            // 自定义验证规则
            form.verify({
                pass: [
                    /^[\S]{6,}$/
                    ,'密码至少6位，且不能出现空格'
                ]
            });

            // 表单提交
            form.on('submit(registerForm)', function(data){
                return true; // 允许表单提交
            });
        });
    </script>
</body>
</html>
