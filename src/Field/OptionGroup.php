<?php

namespace Administr\Form\Field;

class OptionGroup extends Field
{
    protected  $values = [];

    public function __construct($label, array $options)
    {
        parent::__construct('OptionGroup.' . $label, $label);

        foreach($options as $value => $label) {
            $this->values[] = new Option($value, $label);
        }
    }

    public function setValue($value)
    {
        foreach($this->values as $option) {
            $option->setValue($value);
        }

        return parent::setValue($value);
    }

    public function options()
    {
        return $this->values;
    }
}
