<?php

namespace Administr\Form\Field;

class Checkbox extends Text
{
    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->getOptions(), $attributes);

        $value = request($this->name, $this->getOption('value'));

        if ($this->isChecked($value)) {
            $this->options['checked'] = 'checked';
        }

        return parent::render($attributes);
    }
}
