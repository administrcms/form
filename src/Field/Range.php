<?php

namespace Administr\Form\Field;

class Range extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'range';
    }
}