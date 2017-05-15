# PMD — Projektmetadaten
thomas.pfuhl@mfn-berlin.de   
DFG-Projekt gfbio   
&copy; MfN 15. Mai 2017

## Purpose
Provide a webframework with CRUD functionalities for the metadata of research Projects.  
(PMD is an acronym for Project MetaData). The underlying data architecture is generated on-the-fly via a backend-UI.

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

    PMD_HOME=/usr/share/app
    EDIT=/usr/bin/gedit
    cd $PMD_HOME

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

Please note that there is an environment file ``$PMD_HOME/.env`` which overwrites
the settings defined in  ``config/database.php`` and other config files.


Install the dependencies listed in ``$PMD_HOME/package.json`` with:

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

Create the database `projektmetadatren` with utf-8 collation (uft8_general_ci).



### using Laravel migration utility
creates migration classes in folder ``$PMD_HOME/database/migrations``

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

    ../../liquibase update   --defaultsFile=$PMD_HOME/database/liquibase/changelog.xml

main changelog must be an XML file   
chained changelog files may be XML or SQL files  

### Models
(re)generate models depending on the database schemes, **must be executed after each schema modification**:

    php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK --verbose

The Accessors (getters) and Mutators (setters) are magic methods,
but one may add some methods to the generated model:

    $EDIT app/Models/Project.php &


### Database initial seed
creates seeder classes in folder ``$PMD_HOME/database/seeds``

Table users: username=admin@admin.com   password=admin  
Table users: username=user@user.com   password=user  
Table projects: some dummy records

    php artisan db:seed  
    php artisan db:seed --class=ProjectsTableSeeder

## Frontend
If you use docker, point your browser to ``http://172.17.0.2`` or some similar IP.

## Backend
- point your browser to ``http://172.17.0.2/auth/login``,
- log in with  administrator credentials,
- go to ``http://172.17.0.2/admin/dashboard``
