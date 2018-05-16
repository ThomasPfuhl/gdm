<?php

/** Read .env file
 * @path string
 * */
function readEnvFile($path) {
    if (!is_string($path)) {
        return false;
    }

    $file = fopen($path, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if ($line != "") {
                $bits = explode("=", $line);
                if (count($bits) > 1)
                    $result[strtoupper(trim($bits[0]))] = trim($bits[1], '"');
            }
        }
        fclose($file);
        return $result;
    } else
        return false;
}

/**
 * Singularize a string.
 * Converts a word to english singular form.
 * @param string
 */
function singularize($params) {
    if (is_string($params)) {
        $word = $params;
    } else if (!$word = $params['word']) {
        return false;
    }
    $singular = array(
        '/(quiz)zes$/i' => '\\1',
        '/(matr)ices$/i' => '\\1ix',
        '/(vert|ind)ices$/i' => '\\1ex',
        '/^(ox)en/i' => '\\1',
        '/(alias|status)es$/i' => '\\1',
        '/([octop|vir])i$/i' => '\\1us',
        '/(cris|ax|test)es$/i' => '\\1is',
        '/(shoe)s$/i' => '\\1',
        '/(o)es$/i' => '\\1',
        '/(bus)es$/i' => '\\1',
        '/([m|l])ice$/i' => '\\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\\1',
        '/(m)ovies$/i' => '\\1ovie',
        '/(s)eries$/i' => '\\1eries',
        '/([^aeiouy]|qu)ies$/i' => '\\1y',
        '/([lr])ves$/i' => '\\1f',
        '/(tive)s$/i' => '\\1',
        '/(hive)s$/i' => '\\1',
        '/([^f])ves$/i' => '\\1fe',
        '/(^analy)ses$/i' => '\\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\2sis',
        '/([ti])a$/i' => '\\1um',
        '/(n)ews$/i' => '\\1ews',
        '/s$/i' => ''
    );
    $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves'
    );
    $ignore = array(
        'equipment',
        'information',
        'rice',
        'money',
        'species',
        'series',
        'fish',
        'sheep',
        'press',
        'sms',
    );
    $lower_word = strtolower($word);
    foreach ($ignore as $ignore_word) {
        if (substr($lower_word, (-1 * strlen($ignore_word))) == $ignore_word) {
            return $word;
        }
    }
    foreach ($irregular as $singular_word => $plural_word) {
        if (preg_match('/(' . $plural_word . ')$/i', $word, $arr)) {
            return preg_replace('/(' . $plural_word . ')$/i', substr($arr[0], 0, 1) . substr($singular_word, 1), $word);
        }
    }
    foreach ($singular as $rule => $replacement) {
        if (preg_match($rule, $word)) {
            return preg_replace($rule, $replacement, $word);
        }
    }
    return $word;
}

/**
 * get all column meta-infos from given table
 *
 * @param string $table_name
 * @return string
 */
function getFields(string $table_name) {

    $env = readEnvFile("../../.env");

    $pdo = new PDO('mysql:host=' . $env["DB_HOST"] . ';' . 'dbname=' . $env["DB_DATABASE"], $env["DB_USERNAME"], $env["DB_PASSWORD"]);

//    $q = $pdo->prepare("DESCRIBE $table_name");
//    $q->execute();
//    $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

    $q = $pdo->prepare("SELECT * FROM $table_name limit 1");
    $q->execute();
    $table_fields = $q->fetch();
    $out = "";
    for ($i = 0; $i < $q->columnCount(); $i++) {
        $info = $q->getColumnMeta($i);
        if ($info["native_type"] !== "TIMESTAMP" )
        //if ($info["name"] !== "id" && $info["native_type"] !== "TIMESTAMP" )
            {
            $out .= $info["name"] . ":" . $info["native_type"] . ",";
            //echo "\n" . $info["name"] . ":" . $info["native_type"];
        }
    }
    return substr($out, 0, strlen($out)-1);
}

/**
 * Get all foreign key columns.
 *
 * get columns referenced by other tables as foreign keys
 * @author thomas.pfuhl@mfn-berlin.de
 * @todo currently works only for mySQL
 *
 * @return array
 */
function getAllForeignKeys() {

    $env = readEnvFile("../../.env");

// get all tables from schema
    $sql = "SELECT
                    TABLE_NAME as table_name,
                    COLUMN_NAME as foreign_key,
                    REFERENCED_TABLE_NAME as referenced_table,
                    CONCAT(REFERENCED_TABLE_NAME, '.', REFERENCED_COLUMN_NAME) as referenced_key
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = '" . $env["DB_DATABASE"] . "' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOG' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOGLOCK'";

    $pdo = new PDO('mysql:host=' . $env["DB_HOST"] . ';' . 'dbname=' . $env["DB_DATABASE"], $env["DB_USERNAME"], $env["DB_PASSWORD"]);
    $response = $pdo->query($sql);

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


function getForeignKeys($schema, $name) {
    $sql = "SELECT
                    TABLE_NAME as table_name,
                    COLUMN_NAME as foreign_key,
                    REFERENCED_TABLE_NAME as referenced_table,
                    CONCAT(REFERENCED_TABLE_NAME, '.', REFERENCED_COLUMN_NAME) as referenced_key
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = '" . $schema . "'"
            . " AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOG' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOGLOCK'"
            . " AND TABLE_NAME = '$name'"
            ;

    $pdo = new PDO(DB_CONNECTION . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $response = $pdo->query($sql);
    $result = array();
    foreach ($response as $row) {
        $result[] = $row;
    }
    return $result;
}


function toCamelCase($string, $capitalizeFirstCharacter = true) {

    $str = str_replace('_', '', ucwords($string, '_'));
    return $str;
}

function toHyphen($string) {

    $str = str_replace('_', '-', strtolower($string));
    return $str;
}
