<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>待审核文章 - 管理后台</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <style>
        body {
            background: #f5f5f5;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #fff;
            text-align: center;
            margin: 0;
            font-size: 24px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .article-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .article-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0 0 10px 0;
        }
        .article-meta {
            color: #999;
            font-size: 13px;
        }
        .article-meta span {
            margin-right: 15px;
        }
        .article-meta i {
            margin-right: 5px;
        }
        .article-content {
            color: #666;
            line-height: 1.8;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 15px;
            max-height: 150px;
            overflow: hidden;
            position: relative;
        }
        .article-content::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(transparent, #f9f9f9);
        }
        .article-actions {
            display: flex;
            gap: 10px;
        }
        .btn-approve {
            background: linear-gradient(135deg, #5FB878 0%, #009688 100%);
        }
        .btn-reject {
            background: linear-gradient(135deg, #FF5722 0%, #E64A19 100%);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }
        .pagination-wrapper {
            text-align: center;
            margin-top: 20px;
        }
        .nav-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .nav-links a {
            color: #667eea;
        }
        .nav-links a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1><i class="layui-icon layui-icon-read"></i> 待审核文章管理</h1>
        </div>
    </div>

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('home') }}"><i class="layui-icon layui-icon-return"></i> 返回首页</a>
            <span>当前用户：{{ auth()->user()->name }} (管理员)</span>
        </div>

        @if(session('success'))
            <div class="layui-bg-green" style="padding: 15px; margin-bottom: 20px; border-radius: 5px; color: #fff;">
                <i class="layui-icon layui-icon-ok-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($articles->count() > 0)
            @foreach($articles as $article)
                <div class="article-card">
                    <div class="article-header">
                        <div>
                            <h3 class="article-title">{{ $article->title }}</h3>
                            <div class="article-meta">
                                <span><i class="layui-icon layui-icon-username"></i> {{ $article->user->name }}</span>
                                <span><i class="layui-icon layui-icon-note"></i> {{ $article->category->name ?? '未分类' }}</span>
                                <span><i class="layui-icon layui-icon-time"></i> {{ $article->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="article-content">
                        {{ Str::limit($article->content, 300) }}
                    </div>

                    <div class="article-actions">
                        <form action="{{ route('admin.articles.approve', $article->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="layui-btn btn-approve" onclick="return confirm('确定要批准这篇文章吗？')">
                                <i class="layui-icon layui-icon-ok"></i> 批准发布
                            </button>
                        </form>
                        
                        <button type="button" class="layui-btn btn-reject" onclick="showRejectDialog({{ $article->id }}, '{{ $article->title }}')">
                            <i class="layui-icon layui-icon-close"></i> 拒绝
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="pagination-wrapper">
                {{ $articles->links() }}
            </div>
        @else
            <div class="article-card">
                <div class="empty-state">
                    <i class="layui-icon layui-icon-face-surprised"></i>
                    <p>暂无待审核的文章</p>
                </div>
            </div>
        @endif
    </div>

    <!-- 拒绝原因对话框 -->
    <div id="rejectDialog" style="display: none; padding: 20px;">
        <form id="rejectForm" method="POST">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">拒绝原因</label>
                <div class="layui-input-block">
                    <textarea name="reject_reason" id="rejectReason" placeholder="请输入拒绝原因" 
                              class="layui-textarea" lay-verify="required" style="height: 120px;"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn btn-reject" lay-submit lay-filter="rejectForm">
                        确认拒绝
                    </button>
                    <button type="button" class="layui-btn layui-btn-primary" onclick="layer.closeAll()">取消</button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('layui/layui.js') }}"></script>
    <script>
        layui.use(['layer', 'form'], function(){
            var layer = layui.layer;
            var form = layui.form;
            var currentArticleId = null;

            // 显示拒绝对话框
            window.showRejectDialog = function(articleId, articleTitle) {
                currentArticleId = articleId;
                document.getElementById('rejectForm').action = '/admin/articles/' + articleId + '/reject';
                document.getElementById('rejectReason').value = '';
                
                layer.open({
                    type: 1,
                    title: '拒绝文章：' + articleTitle,
                    area: ['500px', '300px'],
                    content: document.getElementById('rejectDialog'),
                    cancel: function() {
                        document.getElementById('rejectDialog').style.display = 'none';
                    }
                });
            };

            // 表单提交
            form.on('submit(rejectForm)', function(data){
                var reason = document.getElementById('rejectReason').value.trim();
                if (!reason) {
                    layer.msg('请填写拒绝原因', {icon: 2});
                    return false;
                }
                
                // 提交表单
                document.getElementById('rejectForm').submit();
                return false;
            });
        });
    </script>
</body>
</html>
