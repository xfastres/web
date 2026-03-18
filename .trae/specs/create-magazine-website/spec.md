# 杂志网站系统 Spec

## Why
搭建一个在线杂志网站，允许用户浏览文章、投稿文章，管理员审核投稿，实现内容发布与管理的完整流程。

## What Changes
- 创建用户认证系统（登录/注册）
- 创建文章管理模块（查看、投稿、审核）
- 创建用户投稿历史记录功能
- 创建全站文章搜索功能
- 配置远程MySQL数据库连接
- 创建管理员审核后台

## Impact
- 新增数据库表：users, articles, categories, article_status
- 新增控制器：AuthController, ArticleController, AdminController, SearchController
- 新增视图：登录/注册页面、文章列表页、文章详情页、投稿页面、投稿历史页、管理员审核页
- 修改配置：.env 数据库连接配置

## ADDED Requirements

### Requirement: 用户认证系统
系统应提供完整的用户认证功能，包括注册、登录、登出。

#### Scenario: 用户注册
- **WHEN** 用户填写注册表单（用户名、邮箱、密码）
- **THEN** 系统验证信息有效性，创建新用户账户，自动登录

#### Scenario: 用户登录
- **WHEN** 用户输入正确的邮箱和密码
- **THEN** 系统验证身份，创建会话，跳转到首页

#### Scenario: 用户登出
- **WHEN** 用户点击登出按钮
- **THEN** 系统销毁会话，跳转到登录页面

### Requirement: 文章浏览功能
系统应允许所有用户浏览已发布的文章。

#### Scenario: 查看文章列表
- **WHEN** 用户访问首页或文章列表页
- **THEN** 系统显示所有已发布文章的列表，包含标题、摘要、作者、发布时间

#### Scenario: 查看文章详情
- **WHEN** 用户点击某篇文章
- **THEN** 系统显示文章完整内容，包含标题、正文、作者、发布时间、分类

### Requirement: 用户投稿功能
注册用户可以提交文章投稿，投稿需要经过管理员审核才能发布。

#### Scenario: 提交投稿
- **WHEN** 登录用户填写投稿表单（标题、分类、正文）
- **THEN** 系统保存投稿，状态设为"待审核"，显示提交成功提示

#### Scenario: 投稿验证
- **WHEN** 用户提交的投稿信息不完整或格式错误
- **THEN** 系统显示错误提示，要求用户修正

### Requirement: 投稿历史记录
用户可以查看自己所有的投稿记录及其审核状态。

#### Scenario: 查看投稿历史
- **WHEN** 用户访问"我的投稿"页面
- **THEN** 系统显示该用户所有投稿的列表，包含标题、状态、提交时间、审核时间

### Requirement: 管理员审核功能
管理员可以审核用户投稿，批准或拒绝投稿。

#### Scenario: 查看待审核投稿
- **WHEN** 管理员访问审核管理页面
- **THEN** 系统显示所有待审核投稿的列表

#### Scenario: 批准投稿
- **WHEN** 管理员点击"批准"按钮
- **THEN** 系统更新投稿状态为"已发布"，设置发布时间，文章对所有人可见

#### Scenario: 拒绝投稿
- **WHEN** 管理员点击"拒绝"按钮并填写拒绝原因
- **THEN** 系统更新投稿状态为"已拒绝"，保存拒绝原因

### Requirement: 全站文章搜索
用户可以搜索全站已发布的文章。

#### Scenario: 搜索文章
- **WHEN** 用户在搜索框输入关键词并提交
- **THEN** 系统返回标题或正文包含该关键词的所有已发布文章

#### Scenario: 搜索无结果
- **WHEN** 用户搜索的关键词没有匹配任何文章
- **THEN** 系统显示"未找到相关文章"提示

### Requirement: 数据库配置
系统应连接到指定的远程MySQL数据库。

#### Scenario: 数据库连接
- **WHEN** 应用启动时
- **THEN** 系统成功连接到远程MySQL数据库（47.122.86.37:3306/magazine_db）

## MODIFIED Requirements
无

## REMOVED Requirements
无

## Technical Stack
- **后端框架**: PHP Laravel 8
- **前端框架**: Layui
- **数据库**: MySQL (远程: 47.122.86.37:3306)
- **数据库名**: magazine_db
- **数据库用户**: remote
- **数据库密码**: remote123

## Database Schema

### users 表
| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | string | 用户名 |
| email | string | 邮箱（唯一） |
| password | string | 密码哈希 |
| role | enum | 角色：user, admin |
| created_at | timestamp | 创建时间 |
| updated_at | timestamp | 更新时间 |

### categories 表
| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | string | 分类名称 |
| created_at | timestamp | 创建时间 |
| updated_at | timestamp | 更新时间 |

### articles 表
| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| title | string | 文章标题 |
| content | text | 文章正文 |
| user_id | bigint | 作者ID（外键） |
| category_id | bigint | 分类ID（外键） |
| status | enum | 状态：pending, published, rejected |
| reject_reason | string | 拒绝原因（可选） |
| published_at | timestamp | 发布时间（可选） |
| created_at | timestamp | 创建时间 |
| updated_at | timestamp | 更新时间 |
