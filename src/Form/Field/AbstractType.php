<?php

namespace Administr\Form\Field;


abstract class AbstractType
{
    protected $name;
    protected $label;
    protected $options = [];

    public function __construct($name, $label, $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
    }

    public function renderAttributes(array $attrs = [])
    {
        if(count($attrs) === 0)
        {
            return '';
        }

        $attributes = "";
        foreach ($attrs as $attr => $value) {
            $attributes .= " {$attr}=\"{$value}\"";
        }

        return $attributes;
    }

    public function render()
    {
        return $this->renderLabel() . $this->renderField() . $this->renderErrors();
    }

    public function renderLabel()
    {
        return '<label for="'.$this->name.'">' . $this->label . '</label>';
    }

    abstract public function renderField($attributes = []);
    abstract public function renderErrors();
}