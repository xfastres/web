@extends('layouts.app')

@section('title', '我的投稿历史')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="layui-icon layui-icon-file"></i> 我的投稿历史</h2>
    </div>
    <div class="card-body">
        @if($submissions->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f8f8;">
                        <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #eee;">标题</th>
                        <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #eee;">分类</th>
                        <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #eee;">状态</th>
                        <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #eee;">提交时间</th>
                        <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #eee;">审核时间</th>
                        <th style="padding: 12px 15px; text-align: center; border-bottom: 2px solid #eee;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 15px;">
                                <strong>{{ $submission->title }}</strong>
                            </td>
                            <td style="padding: 15px;">
                                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 3px 10px; border-radius: 12px; font-size: 12px;">
                                    {{ $submission->category->name ?? '未分类' }}
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if($submission->status === 'pending')
                                    <span style="background: #ffb800; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 12px;">
                                        <i class="layui-icon layui-icon-time"></i> 待审核
                                    </span>
                                @elseif($submission->status === 'published')
                                    <span style="background: #16baaa; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 12px;">
                                        <i class="layui-icon layui-icon-ok"></i> 已发布
                                    </span>
                                @elseif($submission->status === 'rejected')
                                    <span style="background: #ff5722; color: #fff; padding: 5px 12px; border-radius: 15px; font-size: 12px;">
                                        <i class="layui-icon layui-icon-close"></i> 已拒绝
                                    </span>
                                    @if($submission->reject_reason)
                                        <div style="margin-top: 8px; font-size: 12px; color: #ff5722;">
                                            原因: {{ $submission->reject_reason }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center; color: #666; font-size: 13px;">
                                {{ $submission->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td style="padding: 15px; text-align: center; color: #666; font-size: 13px;">
                                @if($submission->published_at)
                                    {{ $submission->published_at->format('Y-m-d H:i') }}
                                @else
                                    <span style="color: #ccc;">-</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <button onclick="showContent('{{ addslashes($submission->title) }}', `{{ $submission->content }}`)" 
                                        class="layui-btn layui-btn-xs layui-btn-normal">
                                    <i class="layui-icon layui-icon-read"></i> 查看
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- 分页 -->
            <div style="text-align: center; margin-top: 20px;">
                {{ $submissions->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <i class="layui-icon layui-icon-face-surprised" style="font-size: 60px; color: #ddd;"></i>
                <p style="margin-top: 20px; font-size: 16px;">暂无投稿记录</p>
                <a href="{{ route('articles.create') }}" class="btn-primary" style="display: inline-block; text-decoration: none; margin-top: 15px;">
                    <i class="layui-icon layui-icon-edit"></i> 立即投稿
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function showContent(title, content) {
        layui.use('layer', function(){
            var layer = layui.layer;
            var htmlContent = '<div style="padding: 20px;">' +
                '<h3 style="margin: 0 0 15px; padding-bottom: 10px; border-bottom: 1px solid #eee;">' + title + '</h3>' +
                '<div style="line-height: 1.8; color: #333;">' + content.replace(/\n/g, '<br>') + '</div>' +
                '</div>';
            
            layer.open({
                type: 1,
                title: '投稿内容',
                area: ['600px', '400px'],
                content: htmlContent,
                shadeClose: true
            });
        });
    }
</script>
@endpush
