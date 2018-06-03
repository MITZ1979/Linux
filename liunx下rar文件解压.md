一.widonds下打包rar文件并上传

yum install lrzsz
rz test.rar
二、下载并安装rar软件

2.1 下载

mkdir -p  /home/oldboy/tools
cd /home/oldboy/tools
wget http://www.rarlab.com/rar/rarlinux-3.8.0.tar.gz

    1
    2
    3

2.2 安装

tar zxvf rarlinux-3.8.0.tar.gz
cd rar
make
make install 

    1
    2
    3
    4

三、rar命令语法

将/etc 目录压缩为etc.rar 命令为：

rar a etc.rar /etc

    1

将etc.rar 解压 命令为：

rar x etc.rar 
unrar -e etc.tar

    1
    2

四、具体例子

实例：将/etc 目录压缩为etc.rar

[root@yonggetools]# rar a etc.rar /etc
RAR 3.80   Copyright (c) 1993-2008 Alexander Roshal   16 Sep 2008
Shareware version         Type RAR -? for help
Evaluation copy. Please register.
Creating archive etc.rar
Adding    /etc/gdm/securitytokens.conf                                OK 
Adding    /etc/gdm/Init/Default                                       OK 
Adding    /etc/gdm/custom.conf                                        OK 
Adding    /etc/gdm/Xsession                                           OK 
Adding    /etc/gdm/PostSession/Default                                OK 
Adding    /etc/gdm/PreSession/Default                                 OK 
Adding    /etc/gdm/XKeepsCrashing                                     OK 
Adding    /etc/gdm/locale.alias                                       OK 
Adding    /etc/gdm/PostLogin/Default.sample                           OK 
省略若干行......
查看
[root@yonggetools]# ll
总计 26704
-rw-r--r-- 1 root root 26505645 08-20 20:26 etc.rar

    1
    2
    3
    4
    5
    6
    7
    8
    9
    10
    11
    12
    13
    14
    15
    16
    17
    18
    19

将etc.rar 解压：

[root@yonggetools]# rar x etc.rar
RAR 3.80   Copyright (c) 1993-2008 Alexander Roshal   16 Sep 2008
Shareware version         Type RAR -? for help

Extracting from etc.rar
Creating    etc                                                       OK
Creating    etc/gdm                                                   OK
Extracting  etc/gdm/securitytokens.conf                               OK 
Creating    etc/gdm/Init                                              OK
Extracting  etc/gdm/Init/Default                                      OK 
Extracting  etc/gdm/custom.conf                                       OK 
Extracting  etc/gdm/Xsession                                          OK 
Creating    etc/gdm/PostSession                                       OK
Extracting  etc/gdm/PostSession/Default                               OK
省略若干行......

    1
    2
    3
    4
    5
    6
    7
    8
    9
    10
    11
    12
    13
    14
    15

五 更多命令 查看帮助


[root@yonggerar]# rar
RAR 3.80   Copyright (c) 1993-2008 Alexander Roshal   16 Sep 2008
Shareware version         Type RAR -? for help
Usage:     rar <command> -<switch 1> -<switch N> <archive> <files...>
               <@listfiles...> <path_to_extract\>
<Commands>
  a             Add files to archive
  c             Add archive comment
  cf            Add files comment
  ch            Change archive parameters
  cw            Write archive comment to file
  d             Delete files from archive
  e             Extract files to current directory
  f             Freshen files in archive
  i[par]=<str>  Find string in archives
  k             Lock archive
  l[t,b]        List archive [technical, bare]
  m[f]          Move to archive [files only]
  p             Print file to stdout
  r             Repair archive
  rc            Reconstruct missing volumes
  rn            Rename archived files
  rr[N]         Add data recovery record
  rv[N]         Create recovery volumes
  s[name|-]     Convert archive to or from SFX
  t             Test archive files
  u             Update files in archive
  v[t,b]        Verbosely list archive [technical,bare]
  x             Extract files with full path
<Switches>
  -             Stop switches scanning
  ad            Append archive name to destination path
  ag[format]    Generate archive name using the current date
  ap<path>      Set path inside archive
  as            Synchronize archive contents
  av            Put authenticity verification (registered versions only)
  av-           Disable authenticity verification check
  c-            Disable comments show
  cfg-          Disable read configuration
  cl            Convert names to lower case
  cu            Convert names to upper case
  df            Delete files after archiving
  dh            Open shared files
  ds            Disable name sort for solid archive
  dw            Wipe files after archiving
  e[+]<attr>    Set file exclude and include attributes
  ed            Do not add empty directories
  en            Do not put 'end of archive' block
  ep            Exclude paths from names
  ep1           Exclude base directory from names
  ep3           Expand paths to full including the drive letter
  f             Freshen files
  hp[password]  Encrypt both file data and headers
  id[c,d,p,q]   Disable messages
  ierr          Send all messages to stderr
  ilog[name]    Log errors to file (registered versions only)
  inul          Disable all messages
  isnd          Enable sound
  k             Lock archive
  kb            Keep broken extracted files
  m<0..5>       Set compression level (0-store...3-default...5-maximal)
  mc<par>       Set advanced compression parameters
  md<size>      Dictionary size in KB (64,128,256,512,1024,2048,4096 or A-G)
  ms[ext;ext]   Specify file types to store
  n<file>       Include only specified file
  n@            Read file names to include from stdin
  n@<list>      Include files in specified list file
  o[+|-]        Set the overwrite mode
  ol            Save symbolic links as the link instead of the file
  or            Rename files automatically
  ow            Save or restore file owner and group
  p[password]   Set password
  p-            Do not query password
  r             Recurse subdirectories
  r0            Recurse subdirectories for wildcard names only
  rr[N]         Add data recovery record
  rv[N]         Create recovery volumes
  s[<N>,v[-],e] Create solid archive
  s-            Disable solid archiving
  sc<chr>[obj]  Specify the character set
  sfx[name]     Create SFX archive
  si[name]      Read data from standard input (stdin)
  sl<size>      Process files with size less than specified
  sm<size>      Process files with size more than specified
  t             Test files after archiving
  ta<date>      Process files modified after <date> in YYYYMMDDHHMMSS format
  tb<date>      Process files modified before <date> in YYYYMMDDHHMMSS format
  tk            Keep original archive time
  tl            Set archive time to latest file
  tn<time>      Process files newer than <time>
  to<time>      Process files older than <time>
  ts<m,c,a>[N]  Save or restore file time (modification, creation, access)
  u             Update files
  v             Create volumes with size autodetection or list all volumes
  v<size>[k,b]  Create volumes with size=<size>*1000 [*1024, *1]
  ver[n]        File version control
  vn            Use the old style volume naming scheme
  vp            Pause before each volume
  w<path>       Assign work directory
  x<file>       Exclude specified file
  x@            Read file names to exclude from stdin
  x@<list>      Exclude files in specified list file
  y             Assume Yes on all queries
  z[file]       Read archive comment from file

[root@ha-1-1 rar]# unrar          
UNRAR 3.80 freeware      Copyright (c) 1993-2008 Alexander Roshal
Usage:     unrar <command> -<switch 1> -<switch N> <archive> <files...>
               <@listfiles...> <path_to_extract\>
<Commands>
  e             Extract files to current directory
  l[t,b]        List archive [technical, bare]
  p             Print file to stdout
  t             Test archive files
  v[t,b]        Verbosely list archive [technical,bare]
  x             Extract files with full path
<Switches>
  -             Stop switches scanning
  ad            Append archive name to destination path
  ap<path>      Set path inside archive
  av-           Disable authenticity verification check
  c-            Disable comments show
  cfg-          Disable read configuration
  cl            Convert names to lower case
  cu            Convert names to upper case
  dh            Open shared files
  ep            Exclude paths from names
  ep3           Expand paths to full including the drive letter
  f             Freshen files
  id[c,d,p,q]   Disable messages
  ierr          Send all messages to stderr
  inul          Disable all messages
  kb            Keep broken extracted files
  n<file>       Include only specified file
  n@            Read file names to include from stdin
  n@<list>      Include files in specified list file
  o[+|-]        Set the overwrite mode
  or            Rename files automatically
  ow            Save or restore file owner and group
  p[password]   Set password
  p-            Do not query password
  r             Recurse subdirectories
  sl<size>      Process files with size less than specified
  sm<size>      Process files with size more than specified
  ta<date>      Process files modified after <date> in YYYYMMDDHHMMSS format
  tb<date>      Process files modified before <date> in YYYYMMDDHHMMSS format
  tn<time>      Process files newer than <time>
  to<time>      Process files older than <time>
  ts<m,c,a>[N]  Save or restore file time (modification, creation, access)
  u             Update files
  v             List all volumes
  ver[n]        File version control
  vp            Pause before each volume
  x<file>       Exclude specified file
  x@            Read file names to exclude from stdin
  x@<list>      Exclude files in specified list file
  y             Assume Yes on all queries
