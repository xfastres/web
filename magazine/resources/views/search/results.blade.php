<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>搜索结果 - Magazine</title>
    <link rel="stylesheet" href="{{ asset('layui/css/layui.css') }}">
    <style>
        body {
            background: #f5f5f5;
            min-height: 100vh;
        }
        .search-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-header {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .search-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        .search-title span {
            color: #667eea;
        }
        .search-stats {
            color: #666;
            font-size: 14px;
        }
        .search-form {
            margin-top: 20px;
        }
        .search-input-group {
            display: flex;
            gap: 10px;
        }
        .search-input-group .layui-input {
            flex: 1;
            height: 45px;
            border-radius: 5px;
        }
        .search-input-group .layui-btn {
            height: 45px;
            padding: 0 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
        }
        .article-list {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .article-item {
            padding: 25px 30px;
            border-bottom: 1px solid #eee;
            transition: background 0.3s;
        }
        .article-item:hover {
            background: #f9f9f9;
        }
        .article-item:last-child {
            border-bottom: none;
        }
        .article-title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .article-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }
        .article-title a:hover {
            color: #667eea;
        }
        .article-summary {
            color: #666;
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .article-meta {
            display: flex;
            gap: 20px;
            color: #999;
            font-size: 13px;
        }
        .article-meta i {
            margin-right: 5px;
        }
        .no-result {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .no-result i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }
        .no-result p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .no-result .hint {
            font-size: 14px;
            color: #bbb;
        }
        .pagination-container {
            padding: 20px 30px;
            text-align: center;
        }
        .back-home {
            margin-top: 20px;
            text-align: center;
        }
        .back-home a {
            color: #667eea;
            text-decoration: none;
        }
        .back-home a:hover {
            text-decoration: underline;
        }
        /* 高亮搜索关键词 */
        .highlight {
            background: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <!-- 搜索头部 -->
        <div class="search-header">
            <h1 class="search-title">
                搜索结果：<span>{{ $keyword ?: '全部文章' }}</span>
            </h1>
            <p class="search-stats">
                共找到 <strong>{{ $articles->total() }}</strong> 篇相关文章
            </p>
            
            <!-- 搜索表单 -->
            <form class="search-form" action="{{ route('search') }}" method="GET">
                <div class="search-input-group">
                    <input type="text" name="keyword" value="{{ $keyword }}" 
                           placeholder="请输入搜索关键词..." class="layui-input">
                    <button type="submit" class="layui-btn">
                        <i class="layui-icon layui-icon-search"></i> 搜索
                    </button>
                </div>
            </form>
        </div>

        <!-- 搜索结果列表 -->
        @if($articles->count() > 0)
            <div class="article-list">
                @foreach($articles as $article)
                    <div class="article-item">
                        <h2 class="article-title">
                            <a href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <div class="article-summary">
                            {!! Str::limit(strip_tags($article->content), 200) !!}
                        </div>
                        <div class="article-meta">
                            <span>
                                <i class="layui-icon layui-icon-user"></i>
                                {{ $article->user->name ?? '未知作者' }}
                            </span>
                            <span>
                                <i class="layui-icon layui-icon-note"></i>
                                {{ $article->category->name ?? '未分类' }}
                            </span>
                            <span>
                                <i class="layui-icon layui-icon-time"></i>
                                {{ $article->published_at ? $article->published_at->format('Y-m-d H:i') : '未发布' }}
                            </span>
                        </div>
                    </div>
                @endforeach

                <!-- 分页导航 -->
                <div class="pagination-container">
                    {{ $articles->links() }}
                </div>
            </div>
        @else
            <!-- 无结果提示 -->
            <div class="article-list">
                <div class="no-result">
                    <i class="layui-icon layui-icon-search"></i>
                    <p>抱歉，没有找到相关文章</p>
                    <p class="hint">请尝试其他关键词或浏览全部文章</p>
                </div>
            </div>
        @endif

        <!-- 返回首页 -->
        <div class="back-home">
            <a href="{{ route('home') }}"><i class="layui-icon layui-icon-return"></i> 返回首页</a>
        </div>
    </div>

    <script src="{{ asset('layui/layui.js') }}"></script>
    <script>
        layui.use(['layer'], function(){
            var layer = layui.layer;
        });
    </script>
</body>
</html>
