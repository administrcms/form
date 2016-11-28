<?php

namespace Administr\Form\Field;

class RadioGroup extends AbstractType
{
    protected $radios = [];

    public function radios()
    {
        return $this->radios;
    }

    public function radio($label, array $options = [])
    {
        $this->radios[] = (new Radio($this->getName(), $label, $options))->setValue($this->getValue());
        return $this;
    }

    public function setValue($value)
    {
        foreach($this->radios as $radio) {
            $radio->setValue($value);
        }

        return parent::setValue($value);
    }
}
