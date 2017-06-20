# GDM — Generic Data Module
thomas.pfuhl@mfn-berlin.de   
DFG-Projekt gfbio   

## Purpose
Provide a webframework with CRUD functionalities for any relational data base.  
The underlying data architecture is generated 'on build' when deploying with docker.
It can also be modified 'on-run' via a set of php scripts.

## Implementation
- Laravel 5.1
- some Laravel plugins
- Liquibase 3.5.3
- Twitter Bootstrap 3.x
- DataTables dynamic table sorting and filtering
- Colorbox jQuery modal popup

### Requirements

- PHP >= 5.5.9
- OpenSSL PHP Extension (included in php7)
- Mbstring PHP Extension : `sudo apt-get install php-mbstring`   
- Tokenizer PHP Extension (included in php7)
- SQL engine (for example MySQL)
- Composer
- NodeJS:  `sudo apt-get install nodejs; sudo apt-get install npm`

### Preliminaries
set some shell variables which we will use during the installation

    GDM_HOME=/usr/share/app
    EDIT=/usr/bin/gedit
    cd $GDM_HOME

### The project's code

    https://code.naturkundemuseum.berlin/Thomas.Pfuhl/pmd


### Docker
If you use docker, get the file `Dockerfile`, and use the usual docker process. Otherwise:


### Laravel framework
    composer install  
    composer require doctrine/dbal  
    composer require ignasbernotas/laravel-model-generator --dev
    composer update  
    composer update --no-scripts

Please note that there is an environment file ``$GDM_HOME/.env`` which overwrites
the settings defined in  ``config/database.php``, ``config/app.php`` and other config files.


This project makes use of **node** and the node packlage manager **npm**.
A recent version must be installed. Check with ``node -v``.
Install the dependencies listed in ``$GDM_HOME/package.json`` :

    npm install   

Retrieve the frontend dependencies with Bower, compile SASS, and move frontend files into place:   

    gulp

## Liquibase install

    @mkdir database/liquibase   
    cd database/liquibase   
    $EDIT liquibase.properties &   
    touch changelog.xml   
    @mkdir changelogs   

## Database Schemes

A database engine must be installed. We use here mySQL.
Create a database with utf-8 collation (utf8_general_ci).


### using Laravel migration utility
creates migration classes in folder ``$GDM_HOME/database/migrations``

    #php artisan make:migration create_projects_table    
    $EDIT database/migrations/y_m_d_his_create_projects_table.php  &

    php artisan migrate  
    #php artisan up  
    #php artisan down  


### using Liquibase

**Liquibase needs a Java Runtime. A JRE is not part of this distribution.**

    cd database/liquibase   
    ../../liquibase updateSQL   

**liquibase update command must be executed after each schema modification**:

    ../../liquibase update  --defaultsFile=$GDM_HOME/database/liquibase/changelog.xml

main changelog must be an XML file   
chained changelog files may be XML or SQL files  

### Models
(re)generate models depending on the database schemes, **must be executed after each schema modification**      
based on [https://github.com/ignasbernotas/laravel-model-generator](https://github.com/ignasbernotas/laravel-model-generator)

    php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations --getset

With the option `--getset`, Accessors (getters) and Mutators (setters) are defined. 
Nonetheless, feel free to modify the generated code:

    $EDIT app/Models/Project.php &


### Database initial seed
creates seeder classes in folder ``$GDM_HOME/database/seeds``

Table users: username=admin@admin.com   password=admin  
Table users: username=user@user.com   password=user  
Table projects: some dummy records
Table proposals: some dummy records

    composer dump-autoload
    php artisan db:seed  
    php artisan db:seed --class=ProjectsTableSeeder

## Webserver
Install and configure a webserver.

### Frontend
Point your browser to the domain name or IP.
If you use docker,this may be ``http://172.17.0.2`` or some similar IP.

### Backend
- point your browser to ``http://172.17.0.2/auth/login``,
- log in with  administrator credentials,
- go to ``http://172.17.0.2/admin/dashboard``


## to do
[still to do...](TODO.md)