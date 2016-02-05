<?php

namespace Administr\Form\Field;


class Radio extends Text
{
    public function renderField($attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type' => 'radio',
        ]));
    }
}