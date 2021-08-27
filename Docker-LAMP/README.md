# Docker LAMP
![image](https://3.bp.blogspot.com/-P63_HqZZw_k/XDbYNyRevEI/AAAAAAAAFEw/zqQX4qc-aRMIua9WUKHRdrDBU4hbQnm3ACLcBGAs/s640/Docker-Lamp.jpg)

This document describe how to setup LAMP stack with Docker and Container. In this guide, We will setup three Container

o - Apache and php Container

o - MySQL Container

o - PhpMyAdmin Container

**Step 1- Clone git repository to your local machine and change directory**

Run following command to clone reposiory to your local system.
```
git clone https://github.com/amarsingh3d/Docker-LAMP.git
```
**Change Directroy**
```
cd Docker-LAMP
```

**Step 2- Setup prerequisites:**

Before, we provison our LAMP container environment. First, We need to complete some prerequisites.
1-We will setup Two Directories, One for DocumentRoot and Second for MySQL database directory.
  Run the following command to setup two directories. 
```
sh setupdir.sh
```
Copy phpinfo.php to DocumentRoot
```
cp phpinfo.php DocumentRoot
```


Once Directory setup successfully, we can proceed to provision LAMP Container stack

**Step 3- Install docker-compose:**

We need to install docker-compose if it's not already setup. follow the command below to finish the installation.
```
curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```
Make docker-compose executable
```
chmod +x /usr/local/bin/docker-compose
```

**Step 4- Setup Container LAMP stack:**

To provison LAMP stack run following command.
```
docker-compose up
```
Above command will start container in intractive mode, you can launch your container in dattach mode by this command **docker-compose up -d**

**Validate Created Container:**
```
docker ps
```
```
CONTAINER ID        IMAGE                          COMMAND                  CREATED             STATUS              PORTS                            NAMES
326da5972785        phpmyadmin/phpmyadmin          "/run.sh supervisord…"   About an hour ago   Up About an hour    9000/tcp, 0.0.0.0:8080->80/tcp   docker-lamp_phpmyadmin_1
c1a700d81c42        amarsingh3d/apache2.4-php7.2   "/bin/sh -c '/usr/sb…"   About an hour ago   Up About an hour    0.0.0.0:80->80/tcp               docker-lamp_www_1
7480657c8ced        mysql:5.6                      "docker-entrypoint.s…"   About an hour ago   Up About an hour    0.0.0.0:3306->3306/tcp           docker-lamp_db_1
```
All Three Containers are up and running.

**Verify Apache Container and php version using phpinfophp.php file.**

In order to verify Apache container, check your Docker host IP address and access IP Address in the browser. In my case My IP address is following

http://10.0.1.170

![image](https://3.bp.blogspot.com/-zJBHaXuksvQ/XDbp8XugwrI/AAAAAAAAFE8/jOK-LTQzUl8gfSs38aynOdQF8581HSQ4gCLcBGAs/s640/ub.png)

http://10.0.1.170/phpinfo.php

![image](https://4.bp.blogspot.com/-1CzCJtqwCd8/XDbqNfCXhFI/AAAAAAAAFFE/o1PIqBZbBtcRnZ1mh2srVC5T4rYVZsQwACLcBGAs/s640/ubb.png)

**Verify PhpMyAdmin access**

To check PhpMyAdmin login, browse Docker host IP with port 8080

http://10.0.1.170:8080

Enter the User **root** and Password is **test** that we defined in our **docker-compose.yaml** file.

After successful authentication, your output would be like below screenshot

![image](https://1.bp.blogspot.com/-XamxqDQWAGY/XDbrncOgA2I/AAAAAAAAFFQ/ZfYhmfyD_qY_wEebQghH1Zq3ENi5LSAowCLcBGAs/s640/ubbb.png)