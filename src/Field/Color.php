<?php

namespace Administr\Form\Field;

class Color extends Field
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->setOption('type', 'color');

        $this->executeOptions($options);
    }
}