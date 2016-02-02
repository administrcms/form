<?php

namespace Administr\Form\Field;

class Submit extends AbstractType
{
    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'type'  => 'submit',
            'id'    => $this->name,
            'name'  => $this->name,
            'value' => $this->label,
        ], $this->options, $attributes);

        return '<input' . $this->renderAttributes($attrs) . '>';
    }

    public function renderLabel()
    {
        return null;
    }
}