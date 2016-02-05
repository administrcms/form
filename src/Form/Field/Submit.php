<?php

namespace Administr\Form\Field;

class Submit extends Text
{
    public function renderField(array $attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'submit',
            'value' => $this->label,
        ]));
    }

    public function renderLabel()
    {
        return null;
    }

    public function renderErrors(array $errors = [])
    {
        return null;
    }
}