# OA (MOA)  中山大学多媒体管理系统


### 系统运行开发环境
  - 服务器操作系统        `Windows Server 2008`
  - Web服务器              `Apache 2.4.10`
  - 服务器开发语言        `PHP 5.6.5`
  - 数据库                 `MySQL 5.6.22`
  - 后台开发框架            `CodeIgniter 3.0`
  - 前端开发框架            `Bootstrap 3.3.4`

### 部署时需要修改以下配置
1、OA\mmsoa\application\config\config.php文件：
```sh
$config['base_url'] = 'http://localhost/OA/mmsoa';
```
请修改为
```sh
$config['base_url'] = 'http://服务器IP/OA/mmsoa';
```

2、OA\mmsoa\application\config\database.php文件：
```sh
'username' => 'root',
'password' => 'lw',
```
请修改为对应数据库的用户名和密码。
