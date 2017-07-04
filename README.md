# GDM — Generic Data Module

funded by the DFG-Projekt gfbio [German Federation For Biological Data](https://www.gfbio.org)   
written by thomas.pfuhl@mfn-berlin.de at the [Naturkundemuseum Berlin](https://www.naturkundemuseum.berlin)

## Purpose
Provide a webframework with CRUD functionalities for any relational data base.  
The underlying data architecture is generated 'on build' 
but can also be modified 'on-run'.

## Implementation
- Laravel 5.1
- some Laravel plugins
- Twitter Bootstrap 3.x
- DataTables dynamic table sorting and filtering
- Colorbox jQuery modal popup
- optionally: Liquibase 3.5.3

This code has been inspired by 
[https://github.com/mrakodol/Laravel-5-Bootstrap-3-Starter-Site/](https://github.com/mrakodol/Laravel-5-Bootstrap-3-Starter-Site/)

### Requirements

- PHP >= 5.5.9
- OpenSSL PHP Extension (included in php7)
- Mbstring PHP Extension : `sudo apt-get install php-mbstring`   
- Tokenizer PHP Extension (included in php7)
- SQL engine (for example MySQL)
- Composer
- NodeJS:  `sudo apt-get install nodejs; sudo apt-get install npm`


### Docker
If you want to deploy GDM with docker, have a look at the fully automated installer **docker-gdm**,
at `https://code.naturkundemuseum.berlin/MfN-Berlin/docker-gdm` . 

Otherwise build GDM step by step:

### Deployment
Unpack the downloaded tarball or clone the git repository in a folder 
which we will refer to as `$GDM_HOME`.

    cd $GDM_HOME


### Customization

Laravel uses an environment file ``.env`` which overwrites the settings defined 
in  ``config/database.php`` and ``config/app.php``.   
__You have to adapt it to your needs:__
Edit the file `config/env.example`, and define at least all variables `GDM_*` and `DB_*`.

 
All customizing files are located in the folder ``custom``. Please edit them: 
- `about.html` contains a description of your application.
- `custom.js` and `custom.css` adapts the layout to your corporate identity.
Finally provide the logos for your institution and your app: `institution_logo.png`, `app_logo.png`


Once these steps accomplished, create the environment file:

    cp custom/env.example .env

Then run the customizing script: 

    php lib/tools/customize.php


We make use of **node** and the node package manager **npm**.
A recent version must be installed. Check with ``node -v``.
Install the dependencies listed in ``package.json`` :

    npm install   

Retrieve the frontend dependencies with Bower, compile SASS, and move frontend files into place:   
This is an optional step, since the minimzed and compressed files are already provided.

    gulp

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

- Every table should have as its first column the auto_increment primary key field  `id`.
- The second column should be a column with a human readable content, like .e.g `title` or `shortdescription`.
- Foreign key columns should be built with the referenced table name in singular form, followed by `ID`.


### using Laravel migration utility

Create the tables needed by GDM and the tables `foos` and `bars`.
`foos.barID` is a foreign key referencing `bars.id`.

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

- run Liquibase (put executable file in an appropriate folder)  
`update` command must be executed after each schema modification

        cd database/liquibase   
        liquibase updateSQL   
        liquibase update  --defaultsFile=database/liquibase/changelog.xml

### Database initial seed

Populate the database tables `foos` and `bars`.
Liquibase provides Seeder classes in the folder ``database/seeds``

- Table `users`: username=$GDM_MANAGER_NAME  email=$GDM_MANAGER_EMAIL  password=admin  
- Table `users`: username=admin   password=admin  
- Table `users`: username=test_user   password=user  
- Table `foos`: some dummy records
- Table `bars`: some dummy records

        composer dump-autoload
        php artisan db:seed  
        #php artisan db:seed --class=FooTableSeeder
        #php artisan db:seed --class=BarTableSeeder


### Models, Views, Controllers, Menu-Items, Routes
    
We generate models automatically, depending on the database schemes,    
based on [https://github.com/ignasbernotas/laravel-model-generator](https://github.com/ignasbernotas/laravel-model-generator)

This is done in a handy PHP script, and must be executed after each schema modification: 

    cd lib/tools
    php make_ui.php

The script may also be called in the Admin Dashboard, so you do not need a commandline access.   
Make sure that the webuser (e.g. www-data) has write permissions for the folders 
`app/Models`, 
`app/Http/Controllers`,
the file `app/Http/more_routes.php`,
and the file `resources/views/partials/menu-items.blade.php`.
You might have to have sudoers' rights to do so.

    cd $GDM_HOME
    chgrp -R www-data app/Models
    chgrp -R www-data app/Http/Controllers
    chgrp  www-data app/Http/more_routes.php
    chgrp  www-data resources/views/partials/menu-items.blade.php
    chmod -R g+w app/Models
    chmod -R g+w app/Http/Controllers
    chmod -R g+w app/Http/more_routes.php
    chmod -R g+w resources/views/partials/menu-items.blade.php


PENDING: many-to-many relations are yet not generated automagically.   
PENDING: do the same thing for the backend MVC.  




## Webserver
Either install and configure a webserver for $GDM_URL  
or launch the command `php artisan serve` and point your browser  to `http://localhost:8000`

### Frontend
Point your browser to the domain name or IP.
If you use docker, this may be ``http://172.17.0.2`` or some similar IP.

### Backend
- point your browser to ``http://your_IP/auth/login``,
- log in with administrator credentials,
- go to ``http://your_IP/admin/dashboard``

- PENDING: Saving records 
- PENDING: User Rights Management


