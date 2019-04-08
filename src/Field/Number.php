<?php

namespace Administr\Form\Field;

class Number extends Field
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->setOption('type', 'number');

        $this->executeOptions($options);
    }
}