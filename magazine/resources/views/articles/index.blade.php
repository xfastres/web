@extends('layouts.app')

@section('title', '文章列表 - dogsshit')

@section('content')
<div class="layui-card">
    <div class="layui-card-header">
        <div class="layui-row">
            <div class="layui-col-md8">
                <h2 style="margin: 0;">
                    <i class="layui-icon layui-icon-list" style="color: #009688;"></i> 文章列表
                </h2>
            </div>
            <div class="layui-col-md4" style="text-align: right;">
                <form action="{{ route('articles.index') }}" method="GET" class="layui-form">
                    <div class="layui-input-inline" style="width: 200px;">
                        <input type="text" name="search" placeholder="搜索文章标题..."
                               value="{{ request('search') }}" class="layui-input">
                    </div>
                    <button type="submit" class="layui-btn layui-btn-primary">
                        <i class="layui-icon layui-icon-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="layui-card-body">
        @if($articles->count() > 0)
            @foreach($articles as $article)
                <div class="layui-card" style="margin-bottom: 15px; border-left: 3px solid #009688;">
                    <div class="layui-card-body">
                        <div class="layui-row">
                            <div class="layui-col-md9">
                                <h3 style="margin: 0 0 10px 0;">
                                    <a href="{{ route('articles.show', $article->id) }}"
                                       style="color: #333; text-decoration: none; font-size: 18px;">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p style="color: #666; line-height: 1.8; margin: 10px 0;">
                                    {{ Str::limit(strip_tags($article->content), 200) }}
                                </p>
                                <div style="margin-top: 15px;">
                                    @if($article->category)
                                        <span class="layui-badge layui-bg-green" style="margin-right: 10px;">
                                            {{ $article->category->name }}
                                        </span>
                                    @endif
                                    <span style="color: #999; font-size: 13px;">
                                        <i class="layui-icon layui-icon-username"></i>
                                        {{ $article->user->name }}
                                    </span>
                                    <span style="color: #999; font-size: 13px; margin-left: 15px;">
                                        <i class="layui-icon layui-icon-time"></i>
                                        {{ $article->published_at->format('Y-m-d H:i') }}
                                    </span>
                                </div>
                            </div>
                            <div class="layui-col-md3" style="text-align: right; padding-top: 20px;">
                                <a href="{{ route('articles.show', $article->id) }}"
                                   class="layui-btn layui-btn-normal">
                                    <i class="layui-icon layui-icon-read"></i> 阅读全文
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- 分页导航 -->
            <div style="text-align: center; margin-top: 30px;">
                {{ $articles->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 50px 0; color: #999;">
                <i class="layui-icon layui-icon-face-surprised" style="font-size: 60px;"></i>
                <p style="margin-top: 20px; font-size: 16px;">
                    @if(request('search'))
                        未找到与"{{ request('search') }}"相关的文章
                    @else
                        暂无文章
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('articles.index') }}" class="layui-btn layui-btn-primary" style="margin-top: 10px;">
                        <i class="layui-icon layui-icon-return"></i> 查看全部文章
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
