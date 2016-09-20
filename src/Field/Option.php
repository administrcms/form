<?php

namespace Administr\Form\Field;

class Option extends AbstractType
{
    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->options, $attributes);
        $this->value = $this->getName();

        return parent::render($attributes);
    }
}
