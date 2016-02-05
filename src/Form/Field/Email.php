<?php

namespace Administr\Form\Field;


class Email extends Text
{
    public function renderField(array $attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'email',
        ]));
    }
}