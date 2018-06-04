linux下安装MariaDB

2016年10月31日 19:37:27

阅读数：980

MariaDB数据库 分为源代码版本和二进制版本，源代码版本需要cmake编译，这里是二进制版本的安装

# tar zxvf  mariadb-5.5.31-linux-x86_64.tar.gz   

# mv mariadb-5.5.31-linux-x86_64 /usr/local/mysql （必需这样，很多脚本或可执行程序都会直接访问这个目录）

# groupadd mysql                     增加 mysql 属组 

# useradd -g mysql mysql     增加 mysql 用户 并归于mysql 属组 

# chown mysql:mysql -Rf  /usr/local/mysql     设置 mysql 目录的用户及用户组归属。 

# chmod +x -Rf /usr/local/mysql    赐予可执行权限 

# cp /usr/local/mysql/support-files/my-medium.cnf /etc/my.cnf     复制默认mysql配置 文件到/etc 目录 

# /usr/local/mysql/scripts/mysql_install_db --user=mysql   初始化数据 库 

# cp  /usr/local/mysql/support-files/mysql.server    /etc/init.d/mysql   复制mysql服务程序 到系统 目录 

# chkconfig  mysql on   添加mysql 至系统服务并设置为开机启动 


# service  mysql  start  启动mysql

#vim /etc/profile   编辑profile,将mysql的可执行路径加入系统PATH

export PATH=/usr/local/mysql/bin:$PATH 

#source /etc/profile  使PATH生效。

#mysqladmin -u root password 'yourrootpassword' 设定root账号及密码

#mysql -uroot -p  使用root用户登录mysql

[none]>use mysql  切换至mysql数据库。

[mysql]>select user,host,password from user; --查看系统权限

[mysql]>drop user ''@'localhost'; --删除不安全的账户

[mysql]>drop user root@'::1';

[mysql]>drop user root@127.0.0.1;

。。。

[mysql]>select user,host,password from user; --再次查看系统权限，确保不安全的账户均被删除。

[mysql]>flush privileges;  --刷新权限


1）修改字符集为UTF8

#vi /etc/my.cnf

在[client]下面添加 default-character-set = utf8

在[mysqld]下面添加 character_set_server = utf8

修改完重启：#service  mysql  restart 

2）增加错误日志

#vi /etc/my.cnf

在[mysqld]下面添加：

log-error = /usr/local/mysql/log/error.log

general-log-file = /usr/local/mysql/log/mysql.log

修改完重启：#service  mysql  restart 



3) 设置为不区分大小写，linux下默认会区分大小写。

#vi /etc/my.cnf

在[mysqld]下面添加：

lower_case_table_name=1

修改完重启：#service  mysql  restart 


出现  FATAL ERROR: Could not find ./bin/my_print_defaults 解决方法

错误信息：

FATALERROR:Couldnotfind./bin/my_print_defaults

If you are using a binary release, you must run this script from

within the directory the archive extracted into. If you compiled

MySQL yourself you must run 'make install' first.

或

[root@bogon scripts]# /usr/local/mysql/scripts/mysql_install_db --user=mysql&

[1] 16874

[root@bogon scripts]#

FATAL ERROR: Could not find ./bin/my_print_defaults

If you compiled from source, you need to run 'make install' to

copy the software into the correct location ready for operation.

If you are using a binary release, you must either be at the top

level of the extracted archive, or pass the --basedir option

pointing to that location.



解决方法：

 [root@bogon scripts]# /usr/local/mysql/scripts/mysql_install_db --user=mysql --basedir=/usr/local/mysql --datadir=/usr/local/mysql/data &(这点非常重要)

启动mysql时报错 mysqld_safe Logging to '/usr/local/mysql/data/zrf.err'.

错误信息：

[root@zrf ~]# /usr/local/mysql/bin/mysqld_safe --user=mysql&

[1] 3527

[root@zrf ~]# 101021 16:37:39 mysqld_safe Logging to '/usr/local/mysql/data/zrf.err'.

101021 16:37:39 mysqld_safe Starting mysqld daemon with databases from /usr/local/mysql/data

101021 16:37:39 mysqld_safe mysqld from pid file /usr/local/mysql/data/zrf.pid ended

解决办法：

/usr/local/mysql/libexec/mysqld: Table 'mysql.plugin' doesn't exist

问题应该出在这里！重新初始化下数据库看下能否解决问题！

# /usr/local/mysql/bin/mysql_install_db --user=mysql



