# TODO 


## user driven dynamic modification of database tables, in all MVC files

example: create a new table `dummie`

define a shell variable to be passed to the scripts

    NEWTABLE=dummie
    cd lib/tools


### done by user: 
- add liquibase changelog file (GUI pending)

        --liquibase formatted sql

        --changeset id:4 author:thomas.pfuhl dbms:mysql

        --preconditions onFail:HALT onError:HALT

        CREATE TABLE IF NOT EXISTS dummy (
                `id`                 BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                `title`      VARCHAR(100)	COMMENT '${NEWTABLE}'
        ) COMMENT '${NEWTABLE}';
        --rollback drop table ${NEWTABLE};


### done automagically: 
2. run liquibase update

        cd database/liquibase   
        ../../liquibase update   

3. (re)generate model(s)

        php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK --getset

4. generate controller, cloned from ProjectsController

        php add_controller.php ${NEWTABLE}

5. generate views

    create menu item, in the html template `partials/nav.blade.php`   
    add a new `<li>` of parent `<ul class="nav navbar-nav">` :

        php add_menu_item.php ${NEWTABLE}

    create templates in  `resources/views/`

        php add_templates.php ${NEWTABLE}


6. add a route (pending)

        php add_route.php ${NEWTABLE}


PENDING: do the same thing for the backend MVC.

END OF DOCUMENT.