# Tasks

- [x] Task 1: 配置远程数据库连接
  - [x] SubTask 1.1: 修改 .env 文件配置远程数据库连接信息
  - [x] SubTask 1.2: 测试数据库连接是否成功

- [x] Task 2: 创建数据库迁移文件
  - [x] SubTask 2.1: 创建 categories 表迁移文件
  - [x] SubTask 2.2: 修改 users 表迁移文件添加 role 字段
  - [x] SubTask 2.3: 创建 articles 表迁移文件
  - [x] SubTask 2.4: 运行迁移创建数据库表

- [x] Task 3: 创建用户认证系统
  - [x] SubTask 3.1: 创建注册控制器和视图
  - [x] SubTask 3.2: 创建登录控制器和视图
  - [x] SubTask 3.3: 配置认证路由
  - [x] SubTask 3.4: 创建认证中间件

- [x] Task 4: 创建分类管理
  - [x] SubTask 4.1: 创建 Category 模型
  - [x] SubTask 4.2: 创建分类数据库填充

- [x] Task 5: 创建文章模型和控制器
  - [x] SubTask 5.1: 创建 Article 模型及关联关系
  - [x] SubTask 5.2: 创建文章列表控制器方法
  - [x] SubTask 5.3: 创建文章详情控制器方法

- [x] Task 6: 创建用户投稿功能
  - [x] SubTask 6.1: 创建投稿表单视图
  - [x] SubTask 6.2: 创建投稿存储控制器方法
  - [x] SubTask 6.3: 创建投稿验证规则

- [x] Task 7: 创建投稿历史记录功能
  - [x] SubTask 7.1: 创建投稿历史控制器方法
  - [x] SubTask 7.2: 创建投稿历史视图

- [x] Task 8: 创建管理员审核功能
  - [x] SubTask 8.1: 创建管理员中间件
  - [x] SubTask 8.2: 创建待审核列表控制器方法
  - [x] SubTask 8.3: 创建审核（批准/拒绝）控制器方法
  - [x] SubTask 8.4: 创建审核管理视图

- [x] Task 9: 创建全站搜索功能
  - [x] SubTask 9.1: 创建搜索控制器方法
  - [x] SubTask 9.2: 创建搜索结果视图

- [x] Task 10: 创建前端视图和布局
  - [x] SubTask 10.1: 创建主布局模板（使用Layui）
  - [x] SubTask 10.2: 创建首页视图
  - [x] SubTask 10.3: 创建文章列表视图
  - [x] SubTask 10.4: 创建文章详情视图
  - [x] SubTask 10.5: 创建导航栏组件

- [x] Task 11: 创建默认管理员账户
  - [x] SubTask 11.1: 创建管理员账户数据库填充

# Task Dependencies
- [Task 2] depends on [Task 1]
- [Task 3] depends on [Task 2]
- [Task 4] depends on [Task 2]
- [Task 5] depends on [Task 2, Task 4]
- [Task 6] depends on [Task 3, Task 5]
- [Task 7] depends on [Task 6]
- [Task 8] depends on [Task 2, Task 3]
- [Task 9] depends on [Task 5]
- [Task 10] depends on [Task 5]
- [Task 11] depends on [Task 2]
