<?php

namespace Administr\Form\Field;

use Asset;

class Wysiwyg extends Textarea
{
    public function __construct($name, $label, $options = null)
    {
        Asset::wysiwyg();
        parent::__construct($name, $label, $options);

        $this->setView('administr.form::textarea');
        $this->options['class'] = array_get($this->getOptions(), 'class').' administr-wysiwyg';
    }
}
