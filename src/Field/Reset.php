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

    public function render(array $attributes = [])
    {
        $this->options['value'] = $this->getLabel();

        return parent::render(array_merge($this->getOptions(), $attributes));
    }
}
