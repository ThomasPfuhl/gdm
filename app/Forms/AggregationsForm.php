<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AggregationsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('table_name', 'text')
            ->add('grouped_by_field_name', 'text')
            ->add('field_name', 'text')
            ->add('function_name', 'text')
            ->add('submit', 'submit', ['label' => 'Save',  'attr' => ['class' => 'btn btn-success']])
            ->add('clear', 'reset', ['label' => 'Reset',  'attr' => ['class' => 'btn btn-warning']]);
    }
}