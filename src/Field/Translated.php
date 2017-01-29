<?php

namespace Administr\Form\Field;

use Administr\Form\FormBuilder;
use Administr\Localization\Models\Language;

class Translated extends Tabs
{
    protected $builder;

    public function __construct(\Closure $definition)
    {
        $this->builder = new FormBuilder();
        call_user_func($definition, $this->builder);

        parent::__construct('translated', Language::pluck('name', 'id')->toArray());

        $this->setView('administr/form::tabs');

    }

    public function render(array $attributes = [], array $viewData = [])
    {
        $this->define(function(array $builders) {
            foreach($builders as $language_id => $builder) {
                $dataSource = $this->builder->dataSource();
                $builder->dataSource($dataSource);

                foreach ($this->builder->fields() as $name => $field) {
                    $field = clone $field;
                    $field->setName("{$field->getName()}[{$language_id}]");
                    $field->appendOption('translated', true);

                    if ($value = $builder->getValue($name, $language_id)) {
                        $field->appendOption('value', $value);
                        $field->setValue($value);
                    }

                    $builder->add($field);
                }
            }
        });

        return parent::render($attributes, $viewData);
    }

    public function builder($tab = null)
    {
        return $this->builder;
    }
}