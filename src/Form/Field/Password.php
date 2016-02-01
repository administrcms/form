<?php

namespace Administr\Form\Field;


class Password extends AbstractType
{

    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'type'  => 'password',
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        return '<input' . $this->renderAttributes($attrs) . '>';
    }

    public function renderErrors()
    {
        // TODO: Implement renderErrors() method.
    }
}