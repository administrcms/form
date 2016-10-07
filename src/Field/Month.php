<?php

namespace Administr\Form\Field;

class Month extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'month';
    }
}