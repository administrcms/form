<?php

namespace Administr\Form\Field;

use Asset;

class Wysiwyg extends Textarea
{
    public function __construct($name, $label, $options = null)
    {
        Asset::wysiwyg();
        parent::__construct($name, $label, $options);

        $this->setView('administr/form::textarea');
        $this->setOption('class', $this->getOption('class') . ' administr-wysiwyg');

        $this->executeOptions($options);
    }
}
