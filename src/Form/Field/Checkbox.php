<?php

namespace Administr\Form\Field;


class Checkbox extends Text
{
    public function renderField($attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'checkbox',
        ]));
    }
}