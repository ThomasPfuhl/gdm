# PMD — Projektmetadaten
thomas.pfuhl@mfn-berlin.de   
DFG-Projekt gfbio   
Mai 2017

## Purpose
Provide a webframework with CRUD functionalities for the metadata of research Projects.  (PMD is an acronym fpr Project MetaData). The underlying data architecture is generated on-the-fly via a backend-UI.

## Implementation
- Laravel 5.1
- some Laravel plugins
- Liquibase 3.5.3
- Twitter Bootstrap 3.x
- DataTables dynamic table sorting and filtering
- Colorbox jQuery modal popup


## Laravel install

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

    PMD_HOME=/home/pfuhl/NetBeansProjects/moehring
    EDIT=/usr/bin/gedit
    cd $PMD_HOME

### Laravel framework
    #composer install  
    composer require doctrine/dbal  
    composer require ignasbernotas/laravel-model-generator --dev
    #composer require stolz/laravel-schema-spy --dev  
    #composer require laravelcollective/html  
    composer update  

fill in the environement file ``$PMD_HOME/.env``, especially the database settings   

    $EDIT .env &


Install dependencies listed in ``$PMD_HOME/package.json`` with:

    npm install   

retrieve frontend dependencies with Bower, compile SASS, and move frontend files into place:   

    gulp

## Liquibase install

        @mkdir database/liquibase   
        cd database/liquibase   
        $EDIT liquibase.properties &   
        touch changelog.xml   
        @mkdir changelogs   

## Database Schemes

### using Laravel migration utility
creates migration classes in folder ``$PMD_HOME/database/migrations``

    #php artisan make:migration create_projects_table    
    $EDIT database/migrations/y_m_d_his_create_projects_table.php  &

    php artisan migrate  
    #php artisan up  
    #php artisan down  


### using Liquibase
    cd database /liquibase   
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
Assuming the subdomain pmd, point your browser to ``http://pmd.mfn-berlin.de``

## Backend
- point your browser to ``http://pmd.mfn-berlin.de/auth/login``,
- log in with  administrator credentials,
- go to ``http://pmd.mfn-berlin.de/admin/dashboard``
