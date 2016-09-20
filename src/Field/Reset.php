<?php

namespace Administr\Form\Field;

class Reset extends Submit
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr::form.submit');
        $this->options['type'] = 'reset';
    }
}
