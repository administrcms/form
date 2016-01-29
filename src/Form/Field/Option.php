<?php

namespace Administr\Form\Field;


class Option extends AbstractType
{

    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'value' => $this->name
        ], $this->options, $attributes);

        return '<option' . $this->renderAttributes($attrs) . '>' . $this->label . '</option>';
    }

    public function renderLabel()
    {
        return '';
    }

    public function renderErrors()
    {
        // TODO: Implement renderErrors() method.
    }
}