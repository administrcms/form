<?php

namespace Administr\Form\Field;

class Date extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'date';
    }
}