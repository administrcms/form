<?php

namespace Administr\Form\Field;

class Text extends AbstractType
{
    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->options, $attributes);

        $value = $this->getOption('value');

        $this->setValue( old($this->name, $value) );

        return parent::render();
    }
}