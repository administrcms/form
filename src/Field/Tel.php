<?php

namespace Administr\Form\Field;

class Tel extends Field
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setOption('type', 'tel');
        $this->setView('administr/form::text');

        $this->executeOptions($options);
    }
}