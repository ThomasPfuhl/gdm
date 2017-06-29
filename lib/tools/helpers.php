<?php

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
 * Get all foreign key columns.
 *
 * get columns referenced by other tables as foreign keys
 * @author thomas.pfuhl@mfn-berlin.de
 * @todo currently works only for mySQL
 *
 * @return array
 */
function getAllForeignKeys() {

// get all tables from schema
//@todo   use params for DB
    $sql = "SELECT
                    TABLE_NAME as table_name,
                    COLUMN_NAME as foreign_key,
                    REFERENCED_TABLE_NAME as referenced_table,
                    CONCAT(REFERENCED_TABLE_NAME, '.', REFERENCED_COLUMN_NAME) as referenced_key
                FROM
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = '" . "projektmetadaten" . "' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOG' AND REFERENCED_TABLE_NAME != 'DATABASECHANGELOGLOCK'";

    $pdo = new PDO('mysql:host=127.0.0.1;dbname=projektmetadaten', 'root', 'p');
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
