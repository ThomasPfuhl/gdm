# TODO 


## user driven dynamic modification of database tables, in all MVC files

example: create a new table `dummy`

        --liquibase formatted sql

        --changeset id:4 author:thomas.pfuhl dbms:mysql

        --preconditions onFail:HALT onError:HALT

        CREATE TABLE IF NOT EXISTS dummy (
                `id`                 BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                `dummyProperty`      VARCHAR(100)	COMMENT 'dummy'
        ) COMMENT 'main table';
        --rollback drop table dummy;


### done by user: 
- add liquibase changelog file


### done automagically: 
2. run liquibase update

        cd database/liquibase   
        ../../liquibase updateSQL   

3. (re)generate Model(s)

        php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK --getset

4. generate Controller, clone of ProjectsController

        cp app/Http/Controllers/ProjectsController app/Http/Controllers/DummyController

5. generate Views

        cp -r resources/views/project resources/views/dummy
    in  `partials/nav.blade.php`, add a new `<li>` of parent `<ul class="nav navbar-nav">`


do the same thing for the backend MVC.

END OF DOCUMENT.