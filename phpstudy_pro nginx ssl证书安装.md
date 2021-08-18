# phpstudy_pro nginx ssl证书安装


user name:mitz1979

email:1519792930@qq.com

phone number:15015920872

## ssl域名证书审核

	需要添加cname解析或者TX记录解析，本人用的时tx记录解析验证



## 上传nginx ssl证书到/usr/local/phpstudy/certs/ftbcoin.top目录下

 	 ftbcoin.top_nginx_chain.crt
 	 ftbcoin.top_nginx.key
 	 ftbcoin.top_nginx_public.crt

##Nginx 配置 https 出现no "ssl_certificate" is defined问题原因及解决方法

	vim /usr/local/phpstudy/soft/nginx/nginx-1.15/nginx/conf/nginx.conf
	
##添加以下两行到
	http{
		#证书文件
		ssl_certificate /usr/local/phpstudy/certs/ftbcoin.top/ftbcoin.top_nginx_public.crt; 
		ssl_certificate_key /usr/local/phpstudy/certs/ftbcoin.top/ftbcoin.top_nginx.key;
	}
	
vim /usr/local/phpstudy/vhost/nginx/0ftbcoin.top_80.conf

	server{
		listen 80 ;
		server_name ftbcoin.top ;

		root /www/admin/ftbcoin.top_80/wwwroot/public/ ;

		#301重定向
		#rewrite ^(.*)$ https://ftbcoin.top$1 permanent;

		#强制SSL
		rewrite ^(.*)$  https://$host$1 permanent;

		#防盗链


		location / {
			#伪静态
			include /www/admin/ftbcoin.top_80/wwwroot/public/.rewrite.conf;

			#首页
			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			index index.php index.html error/index.html;
		}

		#流量限制


		#防火墙配置
		access_by_lua_file /www/common/waf_lua//access_ctrl.lua;
		set $RulePath "/www/admin/ftbcoin.top_80/data/rule";
		set $logdir "/www/admin/ftbcoin.top_80/log/hacklog";
		set $CCDeny on;
		set $attacklog on;
		set $whiteModule on;
		set $getMatch on;
		set $cookieMatch on;
		set $postMatch on;

		#日志
			error_page  403  /error/403.html;
		error_page  400  /error/400.html;
		error_page  404  /error/404.html;
		error_page  502  /error/502.html;
		error_page  503  /error/503.html;

		#处理PHP
		location  ~ [^/]\.php(/|$) {
			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			fastcgi_pass 127.0.0.1:7221;
			fastcgi_split_path_info  ^(.+\.php)(.*)$;
			fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
			fastcgi_param  PATH_INFO $fastcgi_path_info;
			include fastcgi.conf;
		}

		#DenyFiles
		location ~ ^/(\.user.ini|\.htaccess|\.git|\.svn|\.project|LICENSE|README.md)
		{
			return 404;
		}
	}

	server{
		listen 443 ssl ;
		server_name ftbcoin.top;

		root /www/admin/ftbcoin.top_80/wwwroot/public/;
		#301重定向
		#rewrite ^(.*)$ https://ftbcoin.top$1 permanent;

		#开启SSL
		ssl_protocols TLSv1 TLSv1.1 TLSv1.2;

		#证书文件
		ssl_certificate /usr/local/phpstudy/certs/ftbcoin.top/ftbcoin.top_nginx_public.crt; 
		ssl_certificate_key /usr/local/phpstudy/certs/ftbcoin.top/ftbcoin.top_nginx.key;

		location / {
			#伪静态
			include /www/admin/ftbcoin.top_80/wwwroot/public/.rewrite.conf;

			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			index index.php index.html error/index.html;
		}

		#防盗链


		#流量限制


		#防火墙配置
		access_by_lua_file /www/common/waf_lua//access_ctrl.lua;
		set $RulePath "/www/admin/ftbcoin.top_80/data/rule";
		set $logdir "/www/admin/ftbcoin.top_80/log/hacklog";
		set $CCDeny on;
		set $attacklog on;
		set $whiteModule on;
		set $getMatch on;
		set $cookieMatch on;
		set $postMatch on;

		#日志
			error_page  403  /error/403.html;
		error_page  400  /error/400.html;
		error_page  404  /error/404.html;
		error_page  502  /error/502.html;
		error_page  503  /error/503.html;

		#处理PHP
		location  ~ [^/]\.php(/|$) {
			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			fastcgi_pass 127.0.0.1:7221;
			fastcgi_split_path_info  ^(.+\.php)(.*)$;
			fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
			fastcgi_param  PATH_INFO $fastcgi_path_info;
			include fastcgi.conf;
		}

		#DenyFiles
		location ~ ^/(\.user.ini|\.htaccess|\.git|\.svn|\.project|LICENSE|README.md)
		{
			return 404;
		}
	}
	server{
		listen 80 ;
		server_name www.ftbcoin.top ;

		root /www/admin/ftbcoin.top_80/wwwroot/public/ ;

		#301重定向
		rewrite ^(.*)$ https://ftbcoin.top$1 permanent;

		#强制SSL
		#rewrite ^(.*)$  https://$host$1 permanent;

		#防盗链


		location / {
			#伪静态
			include /www/admin/ftbcoin.top_80/wwwroot/public/.rewrite.conf;

			#首页
			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			index index.php index.html error/index.html;
		}

		#流量限制


		#防火墙配置
		access_by_lua_file /www/common/waf_lua//access_ctrl.lua;
		set $RulePath "/www/admin/ftbcoin.top_80/data/rule";
		set $logdir "/www/admin/ftbcoin.top_80/log/hacklog";
		set $CCDeny on;
		set $attacklog on;
		set $whiteModule on;
		set $getMatch on;
		set $cookieMatch on;
		set $postMatch on;

		#日志
		error_page  403  /error/403.html;
		error_page  400  /error/400.html;
		error_page  404  /error/404.html;
		error_page  502  /error/502.html;
		error_page  503  /error/503.html;

		#处理PHP
		location  ~ [^/]\.php(/|$) {
			root /www/admin/ftbcoin.top_80/wwwroot/public/;
			fastcgi_pass 127.0.0.1:7221;
			fastcgi_split_path_info  ^(.+\.php)(.*)$;
			fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
			fastcgi_param  PATH_INFO $fastcgi_path_info;
			include fastcgi.conf;
		}

		#DenyFiles
		location ~ ^/(\.user.ini|\.htaccess|\.git|\.svn|\.project|LICENSE|README.md)
		{
			return 404;
		}
	}

##安装完成，最后重启nginx服务。

##遇到的坑，在phpstudy添加域名时，端口默认80，不需要修改为443.如：
ftbcoin.top:443 会导致打开错误。
