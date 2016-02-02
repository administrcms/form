<?php

namespace Administr\Form\Field;


class Text extends AbstractType
{
    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'type'  => 'text',
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        return '<input' . $this->renderAttributes($attrs) . '>';
    }
}