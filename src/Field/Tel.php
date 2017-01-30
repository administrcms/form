<?php

namespace Administr\Form\Field;

class Tel extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->options['type'] = 'tel';
        $this->setView('administr/form::text');
    }
}