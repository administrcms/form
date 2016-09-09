<?php

namespace Administr\Form\Field;

class Hidden extends Text
{
    public function renderField(array $attributes = [])
    {
        $attrs = array_merge($this->getOptions(), $attributes);
        $attrs['type'] = 'hidden';

        return parent::renderField($attrs);
    }

    public function renderLabel()
    {
        return '';
    }

    public function renderErrors(array $errors = [])
    {
        return '';
    }
}
