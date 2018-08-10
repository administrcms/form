<?php

namespace Administr\Form\Field;

class Option extends Field
{
    public function render(array $attributes = [], array $viewData = [])
    {
        $value = old(str_replace('[]', '', $this->name), $this->getValue());

        $this->options = array_merge($this->options, $attributes);
        $this->setOption('value', $this->getName());
        $this->setValue($this->getName());

        if($value == $this->getValue() || is_array($value) && in_array($this->getValue(), $value)) {
            $this->setOption('selected', 'selected');
        }

        return parent::render($attributes, $viewData);
    }
}
