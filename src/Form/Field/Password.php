<?php

namespace Administr\Form\Field;


class Password extends Text
{
    public function renderField($attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'password',
            'value' => '',
        ]));
    }
}