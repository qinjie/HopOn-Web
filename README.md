# Hop-On server
<img src="http://i.imgur.com/HOofG19.png" align="left" width="100" height="100" hspace="10" vspace="6"></a>
**Hop-On** is a bicycle sharing system. Hop-On project proposes an **IoT solution** which enable users to share bicycle in convenient way. The system contains 3 components:
- Hop-On Module (mounted on bicycles)
- Hop-On Station (installed at parking areas)
- Hop-On Mobile App
- Hop-On Server
**This repository** is **Hop-On server** of the system.

## Server Description
* **Hop-On Server** uses [Yii2 framework](http://www.yiiframework.com/). It provides API services for Hop-On Mobile App.
* **API URL**: ```188.166.247.154/hopon-web/api/web/index.php/v1/```

## Resources
* [API Reference](https://github.com/qinjie/HopOn-Web/blob/develop/API.md)
* [Database Reference](https://github.com/qinjie/HopOn-Web/blob/develop/Database.md)
* [Yii2 documentation](http://www.yiiframework.com/doc-2.0/guide-index.html)

## Set up server in Ubuntu
Instructions for setting up server
1. Install ```LAMP```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04)
2. Install ```Git```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-14-04)
3. Run ```git clone https://github.com/qinjie/HopOn-Web.git```
4. Install ```Composer```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
5. Go to repository directory. Run ```php init```
6. Run this sql file ```docs/hop_on.sql``` in repository directory.
7. Edit database configuration in ```common/config/main-local.php```
8. Add local parameters in file ```common/config/params-local.php``` as following:
```
<?php
return [
    'API_BASEURL' => 'http://localhost/hopon-web/api/web/index.php/',
    'WEB_BASEURL' => 'http://localhost/hopon-web/frontend/web/index.php/',
    'BACKEND_BASEURL' => 'http://localhost/hopon-web/backend/web/',
];
```
9. Change permissions of these folders to be writable. Run ```chmod -R 777 api/runtime api/web/assets backend/runtime backend/web/assets frontend/runtime frontend/web/assets console/runtime``` in repository directory.
10. Run ```composer install```.
