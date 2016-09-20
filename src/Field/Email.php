<?php

namespace Administr\Form\Field;

class Email extends AbstractType
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);
        $this->setView('administr::form.text');
        $this->options['type'] = 'email';
    }
}
