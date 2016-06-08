<?php

namespace Administr\Form\Field;

class RadioGroup extends AbstractType
{
    protected $radios = [];

    public function __construct($name, $label, \Closure $definition)
    {
        parent::__construct($name, $label, []);

        call_user_func($definition, $this);
    }

    public function radio($label, array $options = [])
    {
        $this->radios[] = new Radio($this->getName(), $label, $options);
        return $this;
    }

    public function renderLabel()
    {
        return '<label for="' . $this->getName() . '" class="control-label">' . $this->getLabel() . '</label><br>';
    }

    public function renderField(array $attributes = [])
    {
        $radios = '';

        foreach($this->radios as $radio) {
            $radio->setValue($this->value);
            $radios .= '<label class="radio-inline">' . $radio->renderField() . $radio->getLabel() . '</label>';
        }

        return $radios;
    }
}