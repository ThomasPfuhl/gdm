<?php

/** Creation Tool for adding forms
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @see http://kristijanhusak.github.io/laravel-form-builder/
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
echo "\n adding form for " . $name;

$field_names = getFields($name);
echo "\nfieldnames: " . $field_names;
 
//php ../../artisan make:form Forms/CTABLENAMEForm --fields="name:text, lyrics:textarea, publish:checkbox"

$content = <<<'COMMAND'
rm -f ../../app/Forms/CTABLENAMEForm.php
(cd ../..; php artisan make:form Forms/CTABLENAMEForm --fields="FIELDS,submit:submit,clear:reset";)
COMMAND;


$content = str_replace('CTABLENAME', ucfirst($name), $content);
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

echo "\nexecuting: " . $content . "\n";
system($content);

$code = file_get_contents('../../app/Forms/' . ucfirst($name) . 'Form.php');
$code = str_replace("'id', 'number'", "'id', 'hidden'", $code);
$code = str_replace("'submit')", "'submit', ['label' => 'Save',  'attr' => ['class' => 'btn btn-success']])", $code);
$code = str_replace("'reset')", "'reset', ['label' => 'Cancel',  'attr' => ['class' => 'btn btn-warning']])", $code);
file_put_contents('../../app/Forms/' . ucfirst($name) . 'Form.php', $code);

//   ->add('submit', 'submit', ['label' => 'Save',  'attr' => ['class' => 'btn btn-success']])
//   ->add('clear', 'reset', ['label' => 'Cancel', 'attr' => ['class' => 'btn btn-info']])


