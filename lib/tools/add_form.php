<?php

/** Creation Tool for adding forms
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn.berlin>
 * @see http://kristijanhusak.github.io/laravel-form-builder/
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */

echo "form, " ;

$field_names = getFields($table_name);
if ($verbose > 1) echo "\nFIELD NAMES: " . $field_names;

$foreignKeys = getForeignKeys(DB_DATABASE, $table_name);
if ($verbose > 1) echo "\n\nFOREIGN KEYS for table $table_name: " .print_r($foreignKeys ,true);

$content = <<<'COMMAND'
rm -f ../../app/Forms/CTABLENAMEForm.php
(cd ../..; php artisan make:form Forms/CTABLENAMEForm --fields="FIELDS,submit:submit,clear:reset";)
COMMAND;


$content = str_replace('CTABLENAME', $name, $content);
$content = str_replace('FIELDS', $field_names, $content);

$content = str_replace('LONGLONG', 'number', $content);
$content = str_replace('LONG', 'number', $content);
$content = str_replace('FLOAT', 'number', $content);
$content = str_replace('email:VAR_STRING', 'email:email', $content);
$content = str_replace('password:VAR_STRING', 'password:password', $content);
$content = str_replace('url:VAR_STRING', 'url:url', $content);
$content = str_replace('VAR_STRING', 'text', $content);
$content = str_replace('VAR', 'text', $content);
$content = str_replace('STRING', 'text', $content);
$content = str_replace('BLOB', 'textarea', $content);
$content = str_replace('TEXT', 'textarea', $content);
$content = str_replace('DATE', 'date', $content);
$content = str_replace('TIME', 'time', $content);
$content = str_replace('DATETIME', 'datetime-local', $content);

//echo "\nexecuting: " . $content . "\n";
system($content);

$code = file_get_contents('../../app/Forms/' . $name . 'Form.php');

$code = str_replace("'id', 'number'", "'id', 'hidden'", $code);
$code = str_replace("'submit')", "'submit', ['label' => 'Save',  'attr' => ['class' => 'btn btn-success']])", $code);
$code = str_replace("'reset')",  "'reset',  ['label' => 'Reset', 'attr' => ['class' => 'btn btn-warning']])", $code);

foreach ($foreignKeys as $fk) {

  $modelName = ucfirst(singularize(explode("_", $fk['foreign_key'])[0]));
  $modelTableName = $fk['referenced_table'];

  echo "\n\tforeign key: " .  $fk['foreign_key'] . " --referenced model: "  . $modelName . " --referenced table: " . $fk['referenced_table'] ;

  $model_field_names = getFields($modelTableName);
  $model2ndField = explode(":", explode(",", $model_field_names)[1])[0];

  $pattern = "/(add\('" . $fk['foreign_key'] . "\'), ('number')/i";
  $replacement = '$1, "entity", [
              "class" => "\App\Models' . '\\' . $modelName . '"
              ,"property" => "' . $model2ndField .'"
              /*
              ,"query_builder" => function (\App\Models' . '\\' . $modelName . ' $model) {
                  return $model->where("id", $this->getModel()->id);
              }
              */
            ]';
  $code = preg_replace($pattern, $replacement, $code);
  //echo "\nFINAL CODE: =============================\n" . preg_replace($pattern, $replacement, $code) . "\n======================\n\n";
}

file_put_contents('../../app/Forms/' . $name . 'Form.php', $code);
