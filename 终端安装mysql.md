# 终端安装mysql

# 一、安装mysql客户端

  sudo apt install mysql-client-5.7   --安装5.7版本 

  sudo apt install mariadb-client-10.1 --安装10.1版本

# 二、安装mysql服务端

  sudo apt install mariadb-server-10.1





ERROR 2002 (HY000): Can’t connect to local MySQL server through socket ‘/var/run/mysqld/mysqld.sock’ (2)

今天服务器遇到了一个很熟悉的问题

输入


#mysql -u root -p
 
ERROR 2002 (HY000):Can’t connect to local MySQL server
 
 
随即上网找寻答案
 
根据大家提供的方法我逐一尝试
 
方案1.

 1.#ps -A|grep mysql
 
   显示类似：
   
  1829 ?        00:00:00 mysqld_safe
  
   1876 ?        00:00:31 mysqld
   
  2.#kill -9 1829
  
  3.#kill -9 1876
  
  4.#/etc/init.d/mysql restart
  
  5.#mysql -u root -p
 
   他的麻烦解决了,我的还没解决!
 
继续找
方案2

    先查看 /etc/rc.d/init.d/mysqld status 看看m y s q l 是否已经启动.
    
    另外看看是不是权限问题.
    
    ————————————————————————————
    [root@localhost beinan]#chown -R mysql:mysql /var/lib/mysql
    
    [root@localhost beinan]# /etc/init.d/mysqld start
    
    启动 MySQL： [ 确定 ]
    
    [root@localhost lib]# mysqladmin -uroot password ‘123456’
    
    [root@localhost lib]# mysql -uroot -p
    
    Enter password:
    
    Welcome to the MySQL monitor. Commands end with ; or /g.
    
    Your MySQL connection id is 3 to server version: 4.1.11

    Type ‘help;’ or ‘/h’ for help. Type ‘/c’ to clear the buffe
     
    他的也解决了,我的麻烦还在继续,依然继续寻找
     

方案3

    问题解决了，竟然是max_connections=1000 他说太多了，然后改成500也说多，无奈删之问题解决了。
     
    还是不行

方案4
   
     /var/lib/mysql 所有文件权限 改成mysql.mysql
    
     不行不行
 
方案5

         摘要：解决不能通过mysql .sock连接MySQL问题 这个问题主要提示是，不能通过 ‘/tmp/mysql .sock’连到服务器，而php标准配置正是用过’/tmp/mysql .sock’，但是一些mysql 安装方法 将 mysql .sock放在/var/lib/mysql .sock或者其他的什么地方，你可以通过修改/etc/my.cnf文件来修正它，打开文件，可以看到如下的东东：

     　　[mysql d]
       
    　　socket=/var/lib/mysql .sock
      
    　　改一下就好了，但也会引起其他的问题，如mysql 程序连不上了，再加一点：
    　　[mysql ]
      
    　　socket=/tmp/mysql .sock
      
    　　或者还可以通过修改php.ini中的配置来使php用其他的mysql .sock来连，这个大家自己去找找
    　　
    　　或者用这样的方法:
      
    　　ln -s /var/lib/mysql /mysql .sock /tmp/mysql .sock

    成功了,就是这样ln -s /var/lib/mysql /mysql .sock /tmp/mysql .sock

    OK!

  
