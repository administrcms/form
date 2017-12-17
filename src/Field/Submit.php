<?php

namespace Administr\Form\Field;

class Submit extends AbstractType
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::submit');
        $this->setOption('type', 'submit');
        $this->setValue($label);
    }
}
