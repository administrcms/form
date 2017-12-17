<?php

namespace Administr\Form\Field;

class DateTime extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->setOption('type', 'datetime-local');
    }
}