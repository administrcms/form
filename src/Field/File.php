<?php

namespace Administr\Form\Field;

class File extends Field
{
    public function __construct($name, $label, $options = null)
    {
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::text');
        $this->setOption('type', 'file');

        $this->executeOptions($options);
    }
}
