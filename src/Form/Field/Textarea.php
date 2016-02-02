<?php

namespace Administr\Form\Field;


class Textarea extends AbstractType
{
    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        return '<textarea' . $this->renderAttributes($attrs) . '>'. old($this->name) .'</textarea>';
    }
}