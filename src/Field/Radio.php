<?php

namespace Administr\Form\Field;

class Radio extends Text
{
    public function renderField(array $attributes = [])
    {
        $value = array_get(
            array_merge($this->getOptions(), $attributes),
            'value'
        );

        if( $this->isChecked($value) ) {
            $attributes['checked'] = 'checked';
        }

        return parent::renderField(array_merge($attributes, [
            'type' => 'radio'
        ]));
    }
}
