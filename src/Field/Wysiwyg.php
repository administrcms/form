<?php

namespace Administr\Form\Field;

use Asset;

class Wysiwyg extends Textarea
{
    public function __construct($name, $label, array $options)
    {
        Asset::wysiwyg();

        $options['class'] = array_get($options, 'class') . ' administr-wysiwyg';

        parent::__construct($name, $label, $options);
    }
}