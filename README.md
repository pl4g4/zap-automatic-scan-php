# zap-automatic-scan-php

Run automatic scans using ZAP PHP-API

You need to install docker, then pull the image 

```
docker pull owasp/zap2docker-stable
```

Start a new container by running 

```
docker run -p 8090:8090 -i owasp/zap2docker-stable zap.sh -daemon -config api.key=changemenow -port 8090 -host 0.0.0.0
```

Change the APIKEY to anything you would like to use. 

Find your new container and get the id

```
docker ps
```

Run 

```
docker inspect <CONTAINER ID> | grep IPAddress
```

and get the ipaddress of the new container and visit the url on your browser. Ex. http://172.17.0.8:8090/

When ZAP is running clone this repo. 

```
git clone https://github.com/pl4g4/zap-automatic-scan-php.git
```

Run composer to install ZAP dependecis

```
composer install
```

Modify the app.php to use your own settings.
