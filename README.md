# PMD — Projektmetadaten
thomas.pfuhl@mfn-berlin.de   
DFG-Projekt gfbio   
13. Mai 2017

## Purpose
Provide a webframework with CRUD functionalities for the metadata of research Projects.  
(PMD is an acronym fpr Project MetaData). The underlying data architecture is generated on-the-fly via a backend-UI.

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



* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Create database](#step3)
* [Step 4: Install](#step4)
* [Step 5: Start Page](#step5)

-----
<a name="step1"></a>
### Step 1: Get the code - Download the repository

get code from Mfn-Gitlab

    https://code.naturkundemuseum.berlin/Thomas.Pfuhl/pmd

Extract it into home folder.

-----
<a name="step2"></a>
### Step 2: Use Composer to install dependencies

Laravel utilizes [Composer](http://getcomposer.org/) to manage its dependencies. First, download a copy of the composer.phar.
Once you have the PHAR archive, you can either keep it in your local project directory or move to
`usr/local/bin`  to use it globally on your system.

Then run:

    composer install
to install dependencies Laravel and other packages.

-----
<a name="step3"></a>
### Step 3: Create database

If you finished first three steps, now you can create database on your database server(MySQL). You must create database
with utf-8 collation(uft8_general_ci), to install and application work perfectly.
After that, copy .env.example and rename it as .env and put connection and change default database connection name, only database connection, put name database, database username and password.

-----
<a name="step4"></a>
### Step 4: Install


We make use of Bower and Laravel Elixir. Before triggering Elixir, you must first ensure that Node.js is installed on your machine.

    node -v

Install dependencies listed in package.json with:

    npm install

Retrieve frontend dependencies with Bower, compile SASS, and move frontend files into place:

    gulp

Now that you have the environment configured, you need to create a database configuration for it. For create database tables use this command:

    php artisan migrate

And to initial populate database use this:

    php artisan db:seed

Point your web browser to the URL defined by your apache2 or nginx: e.g. if you use docker, it may be this IP:

    http://172.17.0.2/



### Preliminaries
set some shell variables which we will use during the installation

    PMD_HOME=/home/pfuhl/NetBeansProjects/moehring
    EDIT=/usr/bin/gedit
    cd $PMD_HOME

### Laravel framework
    composer install  
    composer require doctrine/dbal  
    composer require ignasbernotas/laravel-model-generator --dev
    #composer require stolz/laravel-schema-spy --dev  
    #composer require laravelcollective/html  
    composer update  
    composer update --no-scripts

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
- point your browser to ``http://172.17.0.2/auth/login``,
- log in with  administrator credentials,
- go to ``http://172.17.0.2/admin/dashboard``
