<?php

namespace Administr\Form\Field;

class Hidden extends Text
{
    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->options, $attributes);

        // Since the hidden type does not have a label,
        // we can use its value to pass the value of the hidden
        if(strlen($this->getOption('value')) === 0) {
            $this->options['value'] = $this->getLabel();
            $this->value = $this->getLabel();
        }

        return parent::render($attributes);
    }
}
