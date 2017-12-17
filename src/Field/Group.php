<?php

namespace Administr\Form\Field;

use Administr\Form\FormBuilder;

class Group extends Field
{
    /**
     * @var FormBuilder
     */
    protected $builder;

    public function __construct($name, $label, \Closure $definition)
    {
        parent::__construct($name, $label, []);

        $this->builder = new FormBuilder();

        call_user_func($definition, $this->builder);
    }

    public function render(array $attributes = [], array $viewData = [])
    {
        $viewData['builder'] = $this->builder();

        foreach($this->builder()->fields() as $field) {
            $field->setValue(data_get($this->builder()->dataSource(), $field->getEscapedName()));
        }

        return parent::render($attributes, $viewData);
    }

    /**
     * @return FormBuilder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * @param $field
     * @return Field
     */
    public function get($field)
    {
        return $this->builder()->get($field);
    }
}