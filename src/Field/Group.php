<?php

namespace Administr\Form\Field;

use Administr\Form\FormBuilder;

class Group extends AbstractType
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

    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->options, $attributes);

        return view($this->getView(), [
            'field' => $this,
            'builder' => $this->builder,
        ]);
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
     * @return AbstractType
     */
    public function get($field)
    {
        return $this->builder()->get($field);
    }
}