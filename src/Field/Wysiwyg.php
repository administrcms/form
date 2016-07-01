<?php

namespace Administr\Form\Field;

use Asset;

class Wysiwyg extends Textarea
{
    public function __construct($name, $label, array $options)
    {
        Asset::wysiwyg();
        parent::__construct($name, $label, $options);
    }

    public function renderField(array $attributes = [])
    {
        $attributes['class'] = array_get($attributes, 'class') . ' administr-wysiwyg';
        return parent::renderField($attributes);
    }
}