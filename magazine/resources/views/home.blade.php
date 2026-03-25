@extends('layouts.app')

@section('title', '首页 - dogsshit')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="layui-icon layui-icon-fire" style="color: #FFD700;"></i> 最新文章</h2>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($articles as $article)
                    <div class="card" style="cursor: pointer; transition: all 0.3s;"
                         onclick="location.href='{{ route('articles.show', $article->id) }}'"
                         onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.08)'">
                        <div style="padding: 15px;">
                            <h3 style="margin: 0 0 10px; font-size: 16px; color: #333;">
                                <a href="{{ route('articles.show', $article->id) }}"
                                   style="color: inherit; text-decoration: none;"
                                   onclick="event.stopPropagation()">
                                    {{ Str::limit($article->title, 30) }}
                                </a>
                            </h3>
                            <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 0 0 15px;">
                                {{ Str::limit(strip_tags($article->content), 80) }}
                            </p>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid #eee;">
                                <span style="color: #999; font-size: 12px;">
                                    <i class="layui-icon layui-icon-username"></i> {{ $article->user->name }}
                                </span>
                                <span style="color: #999; font-size: 12px;">
                                    <i class="layui-icon layui-icon-time"></i> {{ $article->published_at->diffForHumans() }}
                                </span>
                            </div>
                            @if($article->category)
                                <div style="margin-top: 10px;">
                                    <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 3px 10px; border-radius: 12px; font-size: 11px;">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('articles.index') }}" class="btn-primary" style="display: inline-block; text-decoration: none;">
                    <i class="layui-icon layui-icon-more"></i> 查看更多文章
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <i class="layui-icon layui-icon-face-surprised" style="font-size: 60px; color: #ddd;"></i>
                <p style="margin-top: 20px; font-size: 16px;">暂无文章</p>
                @auth
                    <a href="{{ route('articles.create') }}" class="btn-primary" style="display: inline-block; text-decoration: none; margin-top: 15px;">
                        <i class="layui-icon layui-icon-edit"></i> 立即投稿
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
