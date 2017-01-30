<?php

namespace Administr\Form\Field;

class Option extends AbstractType
{
    public function render(array $attributes = [], array $viewData = [])
    {
        $this->options = array_merge($this->options, $attributes);
        $this->options['value'] = $this->getName();
        $this->setValue($this->getName());

        return parent::render($attributes, $viewData);
    }
}
