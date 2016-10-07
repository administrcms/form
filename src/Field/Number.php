<?php

namespace Administr\Form\Field;

class Number extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'number';
    }
}