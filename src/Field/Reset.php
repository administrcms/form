<?php

namespace Administr\Form\Field;

class Reset extends Submit
{
    public function renderField(array $attributes = [])
    {
        return parent::renderField(array_merge($attributes, [
            'type'  => 'reset',
            'value' => $this->label,
        ]));
    }
}
