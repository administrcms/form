<?php

namespace Administr\Form\Field;

class Hidden extends Field
{
    public function __construct($name, $value, $options = null)
    {
        $this->setValue($value);

        $this->setOptions([
            'value' => $value,
            'type' => 'hidden',
        ]);

        parent::__construct($name, null, $options);
    }
}
