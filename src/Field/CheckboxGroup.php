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
}