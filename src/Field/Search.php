<?php

namespace Administr\Form\Field;

class Search extends Text
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->options['type'] = 'search';
    }
}