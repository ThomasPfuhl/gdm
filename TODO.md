# TODO 


## user driven dynamic modification of database tables, in all MVC files

example: create a new table `dummies`

define a shell variable to be passed to the scripts

    # table name should be in plural form
    NEWTABLE=dummies 
    cd lib/tools
    LIQUIBASE=../../liquibase


### done by user: 
1. add liquibase changelog file (GUI pending)

        --liquibase formatted sql

        --changeset id:4 author:thomas.pfuhl dbms:mysql

        --preconditions onFail:HALT onError:HALT

        CREATE TABLE IF NOT EXISTS dummies (
                `id`                 BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                `title`      VARCHAR(100)	COMMENT '${NEWTABLE}'
        ) COMMENT '${NEWTABLE}';
        --rollback drop table ${NEWTABLE};


### done automagically: 

2. run liquibase update

        cd database/liquibase   
        $LIQUIBASE updateSQL
        $LIQUIBASE update   

3. (re)generate model(s)

    based on [https://github.com/ignasbernotas/laravel-model-generator](https://github.com/ignasbernotas/laravel-model-generator)

        php artisan make:models --force=FORCE --ignoresystem --ignore=DATABASECHANGELOG,DATABASECHANGELOGLOCK,migrations --getset

    This creates the Model class, defining the Properties, Accessors and Mutators.   
    We ignore the liquibase- and laravel-specific tables.
    I modified the Plugin to create the One-to-One-Relations defined by the foreign key constraints, such like

        public function project() {
            return $this->hasOne('App\Models\Project', 'id', 'projectID'); // one to one relation
        }

4. generate controllers and views

        php make_ui.php



PENDING: many-to-many relations   

PENDING: do the same thing for the backend MVC.

## write Tests

END OF DOCUMENT.