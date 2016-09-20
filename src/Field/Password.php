<?php

namespace Administr\Form\Field;

class Password extends AbstractType
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->options['type'] = 'password';
    }

    public function getValue()
    {
        return null;
    }
}
