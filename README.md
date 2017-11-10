# GDM — Generic Data Module

funded by the DFG-Projekt gfbio [German Federation For Biological Data](https://www.gfbio.org)   
written by thomas.pfuhl@mfn-berlin.de at the [Museum für Naturkunde Berlin](https://www.naturkundemuseum.berlin)

## Purpose
Provide a webframework with CRUD functionalities for any relational data base.  
The underlying data architecture is generated 'on build' 
but can also be modified 'on-run'.

## Implementation
- Laravel 5.1
- Twitter Bootstrap 3.3.7
- DataTables: dynamic table sorting and filtering
- Colorbox: jQuery modal popup
- Swagger: API generating tool 
- optionally: Liquibase 3.5.3

This code has been inspired by 
[https://github.com/mrakodol/Laravel-5-Bootstrap-3-Starter-Site/](https://github.com/mrakodol/Laravel-5-Bootstrap-3-Starter-Site/)

### Requirements

- PHP >= 5.6
- OpenSSL PHP Extension (included in php7)
- Mbstring PHP Extension : `sudo apt-get install php-mbstring`   
- Tokenizer PHP Extension (included in php7)
- SQL engine (for example MySQL)
- Composer: see `https://getcomposer.org/`
- NodeJS:  `sudo apt-get install nodejs; sudo apt-get install npm`


### Docker
If you want to deploy GDM with docker, have a look at the fully automated installer **docker-gdm**,
at [https://code.naturkundemuseum.berlin/MfN-Berlin/docker-gdm](https://code.naturkundemuseum.berlin/MfN-Berlin/docker-gdm) . 

Otherwise build GDM step by step:

### Deployment
Unpack the downloaded tarball or clone the git repository in a folder 
which we will refer to as `GDM_HOME`.

    cd GDM_HOME


### Customization

Laravel uses an environment file ``.env`` which overwrites the settings defined 
in  ``config/database.php`` and ``config/app.php``.   
__You have to adapt it to your needs:__
Edit the file `config/.env.example`, and define at least all variables `GDM_*` and `DB_*`.
 
All customizing files are located in the folder ``custom``. Please edit them:   
- `about.html` contains a description of your application.  
- With `custom.js` and `custom.css` you can adapt the layout to your corporate identity.  
- Finally provide the logos for your institution and your app: `institution_logo.png`, `app_logo.png`  

Once these steps accomplished, create the environment file:

    cp custom/.env.example .env

Then run the customizing script: 

    php lib/tools/customize.php

We make use of **node** and the node package manager **npm**.
A recent version must be installed. Check with ``node -v``.
Install the dependencies listed in ``package.json`` :

    npm install --save-dev

Retrieve the frontend dependencies with Bower, compile SASS, and move frontend files into place:   
This is an optional step, since the minimzed and compressed files are already provided.

    gulp --production

### Laravel framework

    composer dump-autoload
    composer install --no-scripts
    composer update --no-scripts

## Database 

A database engine must be installed. We use here mySQL.
Create a database with utf-8 collation (utf8_general_ci).

### Data Architecture

There are some constraints for the database tables, 
in order to ensure the automatic generation of the User Interface:

- Every table should have as its first column the auto_increment primary key `id`.
- The second column should be a column with a human readable content, like .e.g `title` or `shortdescription`.
- Foreign key columns should be built with the referenced table name in singular form, followed by `_id`.
- Aggregations are displayed in special aggregated views, getting the necessary information from the following table, 
which is under complete control of the user.
 
        CREATE TABLE IF NOT EXISTS aggregations (
            `id`                    BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            `table_name`            VARCHAR(200),
            `grouped_by_field_name` VARCHAR(200),
            `field_name`            VARCHAR(200),
            `function_name`         ENUM('AVG','COUNT','GROUP_CONCAT','MAX','MIN','SUM') 
        ) COMMENT 'aggregations table'; 



### using Laravel migration utility

Create the tables needed by GDM.

    composer dump-autoload
    php artisan migrate  


### using Liquibase (optionally)

- Liquibase needs a Java Runtime. A JRE is not part of this distribution.
- download Liquibase: `curl https://github.com/liquibase/liquibase/releases/download/liquibase-parent-3.5.3/liquibase-3.5.3-bin.tar.gz`
- download DB connector for java, e.g. `https://dev.mysql.com/downloads/connector/j/`
- create Liquibase file structure  
    - read the official liquibase documentation 
    - main changelog must be an XML file   
    - chained changelog files may be XML or SQL files   
 

        @mkdir database/liquibase   
        touch database/liquibase/changelog.xml      
        @mkdir database/liquibase/changelogs   

- if you want to rollout a sample data module, take the provided changelog files in `database/liquibase/changelogs

- run Liquibase (put executable file in an appropriate folder)  
`update` command must be executed after each schema modification

        cd database/liquibase   
        liquibase updateSQL   
        liquibase update  --defaultsFile=database/liquibase/changelog.xml

### Database initial seed

Populate the database tables.
Liquibase provides Seeder classes in the folder ``database/seeds``

- Table `users`: *administrator* : username=`GDM_MANAGER_NAME`  email=`GDM_MANAGER_EMAIL`  password=`admin`  
- Table `users`: *test user*: username=test_user   password=user   (currently not used)

        composer dump-autoload
        php artisan db:seed  


### Models, Views, Controllers, Menu-Items, Routes
    
We generate models automatically, depending on the database schemes,    
based on [https://github.com/ignasbernotas/laravel-model-generator](https://github.com/ignasbernotas/laravel-model-generator)

This is done in a handy PHP script, and must be executed after each schema modification: 

    (cd lib/tools; php make_ui.php)

The script may also be called in the Admin Dashboard, so you do not need a commandline access.   
Make sure that the webuser (e.g. www-data) has write permissions for the folders 
`app/Models`, 
`app/Http/Controllers`,
the file `app/Http/more_routes.php`,
and the file `resources/views/partials/menu-items.blade.php`.
You might have to have sudoers' rights to do so.

    cd GDM_HOME
    chgrp -R www-data app/Models
    chgrp -R www-data app/Http/Controllers
    chgrp  www-data app/Http/routes_datamodel.php
    chgrp  www-data resources/views/partials/menu-items.blade.php
    chmod -R g+w app/Models
    chmod -R g+w app/Http/Controllers
    chmod -R g+w app/Http/more_routes.php
    chmod -R g+w resources/views/partials/menu-items.blade.php

PENDING: many-to-many relations are not yet generated automagically.   

### Generate the API docs:

    php artisan vendor:publish --tag=public
    php artisan vendor:publish --tag=config
    php artisan vendor:publish --tag=views


## Webserver
Either install and configure a webserver for `GDM_URL`  
or launch the command `php artisan serve` and point your browser  to `http://localhost:8000`

### Frontend
Point your browser to the domain name or IP.
If you use docker, this may be `http://172.17.0.2` or some similar IP.

### Backend
1. point your browser to `http://your_IP/auth/login`
2. log in with administrator credentials
3. go to `http://your_IP/admin/dashboard`


### Reference Manual

After having finished the installation, you may generate the reference manual, 
using an appropriate tool processing annotations, e.g. `doxygen` (not provided with this software package).
It may be useful to place the documentation into the public folder: `/doc/referencemanual/html/index.html`

### API

The API comes with a concise and complete documentation, including webforms to try out the endpoints.
- JSON: `/docs`
- GUI:  `/api/_module_name_ /_version_/_tablename_/`


## TO DO
see [TODO.md](TODO.md)

END OF DOCUMENT.