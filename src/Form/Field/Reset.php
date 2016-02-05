<?php

namespace Administr\Form\Field;


class Reset extends Text
{
    public function renderField(array $attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'reset',
            'value' => $this->label,
        ]));
    }

    public function renderLabel()
    {
        return null;
    }
}