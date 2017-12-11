# GDM — Generic Data Module

funded by the DFG-Projekt gfbio [German Federation For Biological Data](https://www.gfbio.org)   
written by thomas.pfuhl@mfn-berlin.de at the [Museum für Naturkunde Berlin](https://www.naturkundemuseum.berlin)

## Purpose
The Generic Data Module is a graphical user interface on top of a MySQL / MariaDB database that allows the users to browse and edit data without any SQL knowledge. See [User stories] (https://code.naturkundemuseum.berlin/Thomas.Pfuhl/gdm/blob/master/GDM_user_stories.pdf)
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
- mySQL engine (The core should work on any SQL, but the UI generation makes specific use of mySQL)
- Composer: see `https://getcomposer.org/`
- NodeJS. see `https://nodejs.org/`



Otherwise build GDM step by step:

### Deployment
Unpack the downloaded tarball or clone the git repository in a folder 
which we will refer to as `$GDM_HOME`.

    cd $GDM_HOME


### Customization

Laravel uses an environment file ``.env`` which overwrites the settings defined 
in  ``config/database.php`` and ``config/app.php``.   
__You have to adapt it to your needs:__
Edit the file `custom/.env.example`, and define at least all variables `GDM_*` and `DB_*`.
 
All customizing files are located in the folder ``custom``. Please edit them:   
- `about.html` contains a description of your application.  
- With `custom.js` and `custom.css` you can adapt the layout to your corporate identity.  
- Finally provide the logos for your institution and your app: `institution_logo.png`, `app_logo.png`  

Once these steps accomplished, create the environment file:

    cp custom/.env.example .env


### Docker
If you want to deploy GDM with docker, have a look at [https://github.com/MfN-Berlin/gdm-docker](https://github.com/MfN-Berlin/gdm-docker). 

Otherwise proceed step by step:

We make use of **node** and the node package manager **npm**.
A recent version must be installed. Check with ``node -v``.
Install the dependencies listed in ``package.json`` :

    npm install 
 
Optional: Retrieve the frontend dependencies with Bower, compile SASS, and move frontend files into place:

    gulp --production

If there are errors, run again `npm install; gulp --production` and it should work. 
The minified scripts and stylesheets are already provided in the distribution, so you only need to run gulp for customizing.
 

### Laravel framework

    composer dump-autoload
    composer install --no-scripts

Generate the application key, which is used for all encrypted data:

    php artisan key:generate


## Database 

A database engine must be installed. We use here mySQL.
Create a database with utf-8 collation (e.g. utf8_general_ci).

### Data Architecture

There are some constraints for the database tables, 
in order to ensure the automatic generation of the User Interface:

- You must not use `gdm_` as prefix for table names.
- Table and column names must be in lower case, contain only letters, numbers and the underscore sign.
- Every table must have as its first column the auto_increment primary key `id`.
- The second column should be a column with a human readable content, like .e.g `title` or `shortdescription`.
- Foreign key columns must be built with the referenced table name in singular form, followed by `_id`.

Aggregations are displayed in special aggregated views, 
which are under the complete dynamic control of the user, via the UI.
 


### Populate the database with basic data

Create the GDM system tables and pupopulate them with minimal data:

    composer dump-autoload
    php artisan migrate  
    php artisan db:seed  

This creates an  administrator account:
username=`GDM_MANAGER_NAME`  email=`GDM_MANAGER_EMAIL`  password=`admin`  



### Populate the database using Liquibase (optional)

- Liquibase needs a Java Runtime. A JRE is not part of this distribution.
- download Liquibase: `curl https://github.com/liquibase/liquibase/releases/download/liquibase-parent-3.5.3/liquibase-3.5.3-bin.tar.gz`
- download a DB connector for java, e.g. `https://dev.mysql.com/downloads/connector/j/`
- create Liquibase file structure  
    - please read the official liquibase documentation 
    - the main changelog file must be an XML file   
    - the chained changelog files may be XML or SQL files   

#### Sample data module

- We provide sample data module, featuring a _money pool for coffee and tea_.
If you want to rollout this _kitty_, take the provided changelog files in `custom/liquibase/example/changelogs`.
Either you import the SQL statements directly into your database and ignore the liquibase procedure, or:

        cp custom/liquibase/example/changelogs/*.sql  database/liquibase/changelogs/

- run Liquibase (put the executable file in an appropriate folder).
Note that the `update` command must be executed after each schema modification.

        cd database/liquibase   
        liquibase updateSQL   
        liquibase update  --defaultsFile=database/liquibase/changelog.xml


### Models, Views, Controllers, Menu-Items, Routes
    
We generate models automatically, depending on the database schemes,    
based on [https://github.com/ignasbernotas/laravel-model-generator](https://github.com/ignasbernotas/laravel-model-generator)



Thue UI is generated by a handy PHP script, and must be executed after each schema modification. 
The script may also be called in the Admin Dashboard, so you do not need a commandline access.   

    (cd lib/tools; php make_ui.php)

PENDING: many-to-many relations are not yet generated automagically.   

Make sure that the webuser (e.g. `www-data`) has the necessary write permissions
in order to regenerate dynamically the User Interface.

    cd $GDM_HOME
    chmod -R g+w app/Models
    chmod -R g+w app/Http/Controllers
    chmod -R g+w resources/views

You might have to have sudoers' rights for the following commands

    chgrp -R www-data app/Models
    chgrp -R www-data app/Http/Controllers
    chgrp -R www-data resources/views
    chgrp  www-data app/Http/routes.php


## Documentation

- A general documentation about the motivation to build GDM is outlined here: `http://your_IP/doc/description.html`

- The API documentation for the given data module is generated as follows:

        php artisan vendor:publish --tag=public
        php artisan vendor:publish --tag=config
        php artisan vendor:publish --tag=views

    Output formats are JSON and Html:
    - JSON: `/docs`
    - GUI:  `/api/_module_name_ /_version_/_tablename_/`

- The reference manual can be generated by e.g. `doxygen` (make sure you have doxygen installed and a Doxyfile created).
It may be useful to place the documentation into the public folder: `/doc/referencemanual/html/index.html`


## Webserver
Either install and configure a webserver for `$GDM_URL`  
or launch the command 

    php artisan serve

and point your browser to `http://localhost:8000`

### Frontend
Point your browser to the domain name or IP.
If you use docker, this may be `http://172.17.0.2` or some similar IP.

### Backend
1. point your browser to `http://your_IP/auth/login`
2. log in with administrator credentials
3. go to `http://your_IP/admin/dashboard`




## Known Issues

- many-to-many relations
- only one foreign key per referenced table

## TO DO

see [TODO.md](TODO.md)
  
END OF DOCUMENT.