<?php

namespace Administr\Form\Field;

class Checkbox extends Text
{
    public function renderField(array $attributes = [])
    {
        if ((array_key_exists('value', $attributes) && (bool) $attributes['value']) ||
            (array_key_exists('value', $this->options) && (bool) $this->options['value'])) {
            $attributes['checked'] = 'checked';
        }

        return parent::renderField(array_merge($attributes, [
            'type' => 'checkbox',
        ]));
    }
}
