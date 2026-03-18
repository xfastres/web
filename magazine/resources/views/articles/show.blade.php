@extends('layouts.app')

@section('title', $article->title . ' - 杂志投稿系统')

@section('content')
<div class="layui-card">
    <div class="layui-card-header">
        <div class="layui-row">
            <div class="layui-col-md8">
                <a href="{{ route('articles.index') }}" class="layui-btn layui-btn-sm layui-btn-primary">
                    <i class="layui-icon layui-icon-return"></i> 返回列表
                </a>
            </div>
            <div class="layui-col-md4" style="text-align: right;">
                @auth
                    @if(auth()->id() == $article->user_id)
                        <a href="{{ route('articles.edit', $article->id) }}"
                           class="layui-btn layui-btn-sm layui-btn-warm">
                            <i class="layui-icon layui-icon-edit"></i> 编辑
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="layui-card-body">
        <!-- 文章标题 -->
        <h1 style="margin: 0 0 20px 0; font-size: 28px; color: #333;">
            {{ $article->title }}
        </h1>

        <!-- 文章元信息 -->
        <div style="padding: 15px; background-color: #f8f8f8; border-radius: 4px; margin-bottom: 20px;">
            <div class="layui-row">
                <div class="layui-col-md4">
                    <span style="color: #666;">
                        <i class="layui-icon layui-icon-username"></i>
                        作者：<strong>{{ $article->user->name }}</strong>
                    </span>
                </div>
                <div class="layui-col-md4">
                    @if($article->category)
                        <span style="color: #666;">
                            <i class="layui-icon layui-icon-note"></i>
                            分类：<span class="layui-badge layui-bg-blue">{{ $article->category->name }}</span>
                        </span>
                    @endif
                </div>
                <div class="layui-col-md4" style="text-align: right;">
                    <span style="color: #666;">
                        <i class="layui-icon layui-icon-time"></i>
                        发布时间：{{ $article->published_at->format('Y-m-d H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 文章内容 -->
        <div class="article-content" style="line-height: 2; font-size: 16px; color: #333;">
            {!! $article->content !!}
        </div>

        <!-- 文章底部信息 -->
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
            <div class="layui-row">
                <div class="layui-col-md6">
                    <span style="color: #999; font-size: 14px;">
                        <i class="layui-icon layui-icon-log"></i>
                        最后更新：{{ $article->updated_at->format('Y-m-d H:i') }}
                    </span>
                </div>
                <div class="layui-col-md6" style="text-align: right;">
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="window.print()">
                        <i class="layui-icon layui-icon-print"></i> 打印文章
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 作者信息卡片 -->
<div class="layui-card" style="margin-top: 20px;">
    <div class="layui-card-header">
        <i class="layui-icon layui-icon-friends" style="color: #FFB800;"></i> 关于作者
    </div>
    <div class="layui-card-body">
        <div class="layui-row">
            <div class="layui-col-md2" style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #009688; border-radius: 50%; margin: 0 auto;
                            display: flex; align-items: center; justify-content: center; color: #fff; font-size: 36px;">
                    {{ mb_substr($article->user->name, 0, 1) }}
                </div>
            </div>
            <div class="layui-col-md10">
                <h3 style="margin: 0 0 10px 0;">{{ $article->user->name }}</h3>
                <p style="color: #666; margin: 0;">
                    <i class="layui-icon layui-icon-email"></i> {{ $article->user->email }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .article-content img {
        max-width: 100%;
        height: auto;
    }
    .article-content pre {
        background-color: #f5f5f5;
        padding: 15px;
        border-radius: 4px;
        overflow-x: auto;
    }
    .article-content blockquote {
        border-left: 4px solid #009688;
        padding-left: 15px;
        margin: 15px 0;
        color: #666;
    }
</style>
@endpush
