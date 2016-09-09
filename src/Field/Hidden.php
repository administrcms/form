<?php

namespace Administr\Form\Field;

class Hidden extends Text
{
    public function renderField(array $attributes = [])
    {
        $attrs = array_merge($this->getOptions(), $attributes);
        $attrs['type'] = 'hidden';

        // Since the hidden type does not have a label,
        // we can use its value to pass the value of the hidden
        if(!array_key_exists('value', $attrs)) {
            $attrs['value'] = $this->getLabel();
        }

        return parent::renderField($attrs);
    }

    public function renderLabel()
    {
        return '';
    }

    public function renderErrors(array $errors = [])
    {
        return '';
    }
}
