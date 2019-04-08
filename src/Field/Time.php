<?php

namespace Administr\Form\Field;

class Time extends Field
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->setOption('type', 'time');

        $this->executeOptions($options);
    }
}