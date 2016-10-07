<?php

namespace Administr\Form\Field;

class Time extends AbstractType
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'time';
    }
}