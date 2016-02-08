<?php

namespace Administr\Form\Field;

class Hidden extends Text
{
    public function renderField(array $attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type'  => 'hidden',
            'value' => array_key_exists('value', $attributes) ? $attributes['value'] : $this->label,
        ]));
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
