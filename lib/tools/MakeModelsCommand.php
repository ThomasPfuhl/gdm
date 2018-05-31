<?php

namespace Iber\Generator\Commands;

use Illuminate\Database\Connection;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Support\Pluralizer;
use Illuminate\Console\GeneratorCommand;
use Iber\Generator\Utilities\RuleProcessor;
use Iber\Generator\Utilities\SetGetGenerator;
use Iber\Generator\Utilities\VariableConversion;
use Symfony\Component\Console\Input\InputOption;

class MakeModelsCommand extends GeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build models from existing schema.';

    /**
     * Default model namespace.
     *
     * @var string
     */
    protected $namespace = 'Models/';

    /**
     * Default class the model extends.
     *
     * @var string
     */
    protected $extends = 'Illuminate\Database\Eloquent\Model';

    /**
     * Rule processor class instance.
     *
     * @var
     */
    protected $ruleProcessor;

    /**
     * Rules for columns that go into the guarded list.
     *
     * @var array
     */
    protected $guardedRules = 'ends:_guarded'; //['ends' => ['_id', 'ids'], 'equals' => ['id']];

    /**
     * Rules for columns that go into the fillable list.
     *
     * @var array
     */
    protected $fillableRules = '';

    /**
     * Rules for columns that set whether the timestamps property is set to true/false.
     *
     * @var array
     */
    //protected $timestampRules = 'ends:_at'; //['ends' => ['_at']];
    protected $timestampRules = 'equals:xxx'; // will be set to false

    /**
     * Contains the template stub for set function
     * @var string
     */
    protected $setFunctionStub;

    /**
     * Contains the template stub for get function
     * @var string
     */
    protected $getFunctionStub;

    /**
     * Contains the template stub for relation function
     * @var string
     */
    protected $getRelationStub;

    /**
     * @var string
     */
    protected $databaseEngine = 'mysql';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        if ($this->option("getset")) {
// load the get/set function stubs
            $folder = __DIR__ . '/../stubs/';

            $this->setFunctionStub = $this->files->get($folder . "setFunction.stub");
            $this->getFunctionStub = $this->files->get($folder . "getFunction.stub");
        }

// create rule processor

        $this->ruleProcessor = new RuleProcessor();
        $this->databaseEngine = config('database.default', 'mysql');

        \Event::listen(StatementPrepared::class, function ($event) {
            /** @var \PDOStatement $statement */
            $statement = $event->statement;
            /** @var Connection $connection */
            $connection = $event->connection;

            $pdo = $connection->getPdo();
            $statement->setFetchMode($pdo::FETCH_CLASS, \stdClass::class);
        });

        $tables = $this->getSchemaTables();

        foreach ($tables as $table) {
            $table = (object) $table;
            $this->generateTable($table->name);
        }
    }

    /**
     * Get schema tables.
     *
     * @return array
     */
    protected function getSchemaTables() {
        $filterTablesWhere = '';
        if ($this->option("tables")) {
            $tableNamesToFilter = explode(',', $this->option('tables'));
            if (is_array($tableNamesToFilter) && count($tableNamesToFilter) > 0) {
                $filterTablesWhere = ' AND table_name IN (\'' . implode('\', \'', $tableNamesToFilter) . '\')';
            }
        }

        switch ($this->databaseEngine) {
            case 'mysql':
                $sql = "SELECT table_name AS name FROM information_schema.tables WHERE (TABLE_TYPE='BASE TABLE' OR TABLE_TYPE='VIEW') AND table_schema = '" . env('DB_DATABASE') . "'" . $filterTablesWhere;
                $tables = \DB::select($sql);
                break;

            case 'sqlsrv':
            case 'dblib':
                $tables = \DB::select("SELECT table_name AS name FROM information_schema.tables WHERE table_type='BASE TABLE' AND table_catalog = '" . env('DB_DATABASE') . "'" . $filterTablesWhere);
                break;

            case 'pgsql':
                $tables = \DB::select("SELECT table_name AS name FROM information_schema.tables WHERE table_schema = 'public' AND table_type='BASE TABLE' AND table_catalog = '" . env('DB_DATABASE') . "'" . $filterTablesWhere);
                break;
        }

        return $tables;
    }

    /**
     * Generate a model file from a database table.
     *
     * @param $table
     * @return void
     */
    protected function generateTable($table) {
//prefix is the sub-directory within app
        $prefix = $this->option('dir');

        $ignoreTable = $this->option("ignore");

        if ($this->option("ignoresystem")) {
            $ignoreSystem = "users,permissions,permission_role,roles,role_user,migrations,password_resets";

            if (is_string($ignoreTable)) {
                $ignoreTable .= "," . $ignoreSystem;
            } else {
                $ignoreTable = $ignoreSystem;
            }
        }

// if we have ignore tables, we need to find all the posibilites
        if (is_string($ignoreTable) && preg_match("/^" . $table . "|^" . $table . ",|," . $table . ",|," . $table . "$/", $ignoreTable)) {
            $this->info($table . ": is ignored.");

            return;
        }

// replace table prefix
        $tablePrefix = $this->option('prefix') ? : \DB::getTablePrefix();
        $prefixRemovedTableName = str_replace($tablePrefix, '', $table);

        $class = VariableConversion::convertTableNameToClassName($prefixRemovedTableName);

        if (method_exists($this, 'qualifyClass')) {
            $name = Pluralizer::singular($this->qualifyClass($prefix . $class));
        } else {
            $name = Pluralizer::singular($this->parseName($prefix . $class));
        }

        if ($this->files->exists($path = $this->getPath($name)) && !$this->option('force')) {
            return $this->error($table . ': ' . $this->extends . ' already exists!');
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->replaceTokens($name, $table));

        $this->info($table . ': ' . $this->extends . ' created successfully.');
    }

    /**
     * Replace all stub tokens with properties.
     *
     * @param $name
     * @param $table
     *
     * @return mixed|string
     */
    protected function replaceTokens($name, $table) {
        $class = $this->buildClass($name);

        $properties = $this->getTableProperties($table);

        $extends = $this->option('extends');

        $class = str_replace('{{table}}', 'protected $table = \'' . $table . '\';', $class);

        $class = str_replace('{{primaryKey}}', $properties['primaryKey'] ? ('protected $primaryKey = \'' . $properties['primaryKey'] . '\';' . "\r\n\r\n\t") : '', $class);

        $class = str_replace('{{extends}}', $extends, $class);
        $class = str_replace('{{shortNameExtends}}', explode('\\', $extends)[count(explode('\\', $extends)) - 1], $class);
        $class = str_replace('{{fillable}}', 'protected $fillable = ' . VariableConversion::convertArrayToString($properties['fillable']) . ';', $class);
        $class = str_replace('{{guarded}}', 'protected $guarded = ' . VariableConversion::convertArrayToString($properties['guarded']) . ';', $class);
        $class = str_replace('{{timestamps}}', 'public $timestamps = ' . VariableConversion::convertBooleanToString($properties['timestamps']) . ';', $class);


        if ($this->option("getset")) {

            $class = $this->replaceTokensWithSetGetFunctions($properties, $class);

            /* thomas.pfuhl@mfn.berlin: one-to-one relations added */
            $foreign_keys = $this->getAllForeignKeys();

//            echo "--------- Tables with foreign keys: \n";
//            echo print_r(array_keys($foreign_keys), true);

            $class = $this->replaceRelationTokensWithFunctions($table, $foreign_keys, $class);
        } else {
            $class = str_replace(["{{setters}}\n\n", "{{getters}}\n\n"], '', $class);
        }

        return $class;
    }

    /**
     * Replaces setters and getters from the stub. The functions are created
     * from provider properties.
     *
     * @param  array  $properties
     * @param  string $class
     * @return string
     */
    protected function replaceTokensWithSetGetFunctions($properties, $class) {
        $getters = "";
        $setters = "";

        $fillableGetSet = new SetGetGenerator($properties['fillable'], $this->getFunctionStub, $this->setFunctionStub);
        $getters .= $fillableGetSet->generateGetFunctions();
        $setters .= $fillableGetSet->generateSetFunctions();

        $guardedGetSet = new SetGetGenerator($properties['guarded'], $this->getFunctionStub, $this->setFunctionStub);
        $getters .= $guardedGetSet->generateGetFunctions();

        return str_replace([
            "{{setters}}",
            "{{getters}}"
                ], [
            $setters,
            $getters
                ], $class);
    }

    /**
     * Replaces relations from the stub. The functions are created
     * from the foreign_keys.
     *
     * @author thomas.pfuhl@mfn.berlin
     * @todo use SetGetGenerator()
     * @param  string  $table
     * @param  array  $foreign_keys
     * @param  string $class
     * @return string
     */
    protected function replaceRelationTokensWithFunctions($table, $foreign_keys, $class) {
        $relations = "";
//$fillableGetSet = new SetGetGenerator($properties['fillable'], $this->getRelationStub, "");
//$relations .= $fillableGetSet->generateGetFunctions();
//$relations = print_r($foreign_keys[$table], true);

        if (array_key_exists($table, $foreign_keys))
            foreach ($foreign_keys[$table] as $relation) {

                $foreign_key = $relation['foreign_key'];
                //$referenced_model = ucfirst($referenced_table_trunc);

                // The public functions for one-to-one relations of a table are not unique as soon as
                // the table has more than one foreign keys that refers to the SAME target table. Thus the whole GDM does not run due to a PHP error.
                // Hence we use the following naming convention:
                //tableName_columnName where columnName contains the foreign key instead of the target table's name as function name.

                $referenced_model = ucfirst(Pluralizer::singular($relation['referenced_table']));
                $referenced_table_trunc = Pluralizer::singular($relation['referenced_table']) . "_" . explode("_",$foreign_key)[0];

                $stub = <<<RELATION

        /**
         * retrieve related $referenced_model
         * @return mixed
         */
        public function $referenced_table_trunc() {
            return \$this->hasOne('App\Models\\$referenced_model', 'id', '$foreign_key'); // one to one relation
        }

RELATION;
                $relations .= $stub;
            }

        return str_replace(["{{relations}}"], [$relations], $class);
    }

    /**
     * Fill up $fillable/$guarded/$timestamps properties based on table columns.
     *
     * @param $table
     *
     * @return array
     */
    protected function getTableProperties($table) {
        $primaryKey = $this->getTablePrimaryKey($table);
        $primaryKey = $primaryKey != 'id' ? $primaryKey : null;

        $fillable = [];
        $guarded = [];

        $timestamps = false;

        $columns = $this->getTableColumns($table);

        foreach ($columns as $column) {
            $column = (object) $column;

//prioritize guarded properties and move to fillable
            if ($this->ruleProcessor->check($this->option('fillable'), $column->name)) {
                if (!in_array($column->name, array_merge(['id', 'created_at', 'updated_at', 'deleted_at'], $primaryKey ? [$primaryKey] : []))) {
                    $fillable[] = $column->name;
                }
            }
            if ($this->ruleProcessor->check($this->option('guarded'), $column->name)) {
                $fillable[] = $column->name;
            }
//check if this model is timestampable
            if ($this->ruleProcessor->check($this->option('timestamps'), $column->name)) {
                $timestamps = true;
            }
        }

//        echo "--------------------getAllForeignKeys() \n";
//        $fk = $this->getAllForeignKeys();
//        echo print_r($fk, true);
//        echo "--------- Tables with foreign keys: \n";
//        echo print_r(array_keys($fk), true);

        return ['primaryKey' => $primaryKey, 'fillable' => $fillable, 'guarded' => $guarded, 'timestamps' => $timestamps];
    }

    /**
     * Get table columns.
     *
     * @param $table
     *
     * @return array
     */
    protected function getTableColumns($table) {
        switch ($this->databaseEngine) {

            case 'mysql':
                $columns = \DB::select("SELECT COLUMN_NAME as `name` FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . env("DB_DATABASE") . "' AND TABLE_NAME = '{$table}'");
                break;

            case 'sqlsrv':
            case 'dblib':
                $columns = \DB::select("SELECT COLUMN_NAME as 'name' FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '" . env("DB_DATABASE") . "' AND TABLE_NAME = '{$table}'");
                break;

            case 'pgsql':
                $columns = \DB::select("SELECT COLUMN_NAME as name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '" . env("DB_DATABASE") . "' AND TABLE_NAME = '{$table}'");
                break;
        }

        return $columns;
    }

    /**
     * Get all foreign key columns.
     *
     * get columns referenced by other tables as foreign keys
     * @author thomas.pfuhl@mfn.berlin
     * @todo currently works only for mySQL
     *
     * @return array
     */
    protected function getAllForeignKeys() {

// get all tables from schema
//        $sql = "SELECT table_name AS name FROM information_schema.tables WHERE table_type='BASE TABLE' AND table_schema = '" . env('DB_DATABASE') . "'";
//        $all_tables = \DB::select($sql);

        $sql = "SELECT
                    TABLE_NAME as table_name,
                    COLUMN_NAME as foreign_key,
                    REFERENCED_TABLE_NAME as referenced_table,
                    CONCAT(REFERENCED_TABLE_NAME, '.', REFERENCED_COLUMN_NAME) as referenced_key
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = '" . env("DB_DATABASE") . "' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOG' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOGLOCK'";
//        $sql .= " AND (0";
//        foreach ($all_tables as $ctable) {
//            $sql .= " OR REFERENCED_TABLE_NAME = '$ctable->name'";
//        }
//        $sql .= ")";

        $response = \DB::select($sql);

        $result = array();
        foreach ($response as $row) {
            $result[] = (array) $row;
        }
        sort($result);


        $out = array();
        foreach ($result as $row) {
            if (array_key_exists($row["table_name"], $out)) {
                array_push($out[$row["table_name"]], $row);
            } else {
                $out[$row["table_name"]] = array();
                array_push($out[$row["table_name"]], $row);
            }
        }

        return $out;
    }

    /**
     * Get table primary key column.
     *
     * @param $table
     *
     * @return string
     */
    protected function getTablePrimaryKey($table) {

        switch ($this->databaseEngine) {
            case 'mysql':
                $primaryKeyResult = \DB::select(
                                "SELECT COLUMN_NAME
                  FROM information_schema.COLUMNS
                  WHERE  TABLE_SCHEMA = '" . env("DB_DATABASE") . "' AND
                         TABLE_NAME = '{$table}' AND
                         COLUMN_KEY = 'PRI'");
                break;

            case 'sqlsrv':
            case 'dblib':
                $primaryKeyResult = \DB::select(
                                "SELECT ku.COLUMN_NAME
                   FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS tc
                   INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS ku
                   ON tc.CONSTRAINT_TYPE = 'PRIMARY KEY'
                   AND tc.CONSTRAINT_NAME = ku.CONSTRAINT_NAME
                   WHERE ku.TABLE_CATALOG ='" . env("DB_DATABASE") . "' AND ku.TABLE_NAME='{$table}';");
                break;

            case 'pgsql':
                $primaryKeyResult = \DB::select(
                                "SELECT ku.COLUMN_NAME AS \"COLUMN_NAME\"
                   FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS tc
                   INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS ku
                   ON tc.CONSTRAINT_TYPE = 'PRIMARY KEY'
                   AND tc.CONSTRAINT_NAME = ku.CONSTRAINT_NAME
                   WHERE ku.TABLE_CATALOG ='" . env("DB_DATABASE") . "' AND ku.TABLE_NAME='{$table}';");
                break;
        }

        if (count($primaryKeyResult) == 1) {
            $table = (object) $primaryKeyResult[0];
            return $table->COLUMN_NAME;
        }

        return null;
    }

    /**
     * Get stub file location.
     *
     * @return string
     */
    public function getStub() {
        return __DIR__ . '/../stubs/model.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['tables', null, InputOption::VALUE_OPTIONAL, 'Comma separated table names to generate', null],
            ['prefix', null, InputOption::VALUE_OPTIONAL, 'Table prefix', null],
            ['dir', null, InputOption::VALUE_OPTIONAL, 'Model directory', $this->namespace],
            ['extends', null, InputOption::VALUE_OPTIONAL, 'Parent class', $this->extends],
            ['fillable', null, InputOption::VALUE_OPTIONAL, 'Rules for $fillable array columns', $this->fillableRules],
            ['guarded', null, InputOption::VALUE_OPTIONAL, 'Rules for $guarded array columns', $this->guardedRules],
            ['timestamps', null, InputOption::VALUE_OPTIONAL, 'Rules for $timestamps columns', $this->timestampRules],
            ['ignore', "i", InputOption::VALUE_OPTIONAL, 'Ignores the tables you define, separated with ,', null],
            ['force', "f", InputOption::VALUE_OPTIONAL, 'Force override', false],
            ['ignoresystem', "s", InputOption::VALUE_NONE, 'If you want to ignore system tables.
            Just type --ignoresystem or -s'],
            ['getset', 'm', InputOption::VALUE_NONE, 'Defines if you want to generate set and get methods']
        ];
    }

}
