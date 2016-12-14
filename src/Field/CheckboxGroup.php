<?php

namespace Administr\Form\Field;

class CheckboxGroup extends AbstractType
{
    protected $checkboxes = [];

    public function checkboxes()
    {
        return $this->checkboxes;
    }

    public function checkbox($label, array $attributes = [])
    {
        $this->checkboxes[] = (new Checkbox($this->getName(), $label, $attributes))->setValue($this->getValue());

        return $this;
    }

    public function setValue($value)
    {
        foreach($this->checkboxes as $checkbox) {
            $checkbox->setValue($value);
        }

        return parent::setValue($value);
    }
}