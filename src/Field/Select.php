<?php

namespace Administr\Form\Field;

class Select extends Field
{
    protected $selectOptions = [];

    public function render(array $attributes = [], array $viewData = [])
    {
        $this->options = array_merge($this->options, $attributes);

        if ($options = $this->getOption('values')) {
            $this->setSelectOptions($options);
        }

        $value = old(str_replace('[]', '', $this->getEscapedName()), $this->getValue());
        unset($this->options['value']);

        foreach($this->selectOptions as $option) {
            $option->setValue($value);
        }

        return parent::render($attributes, $viewData);
    }

    public function option($value, $display, $options = null)
    {
        $this->selectOptions[] = new Option($value, $display, $options);
        return $this;
    }

    public function optionGroup($label, $options)
    {
        $this->selectOptions[] = new OptionGroup($label, $options);
        return $this;
    }

    public function options()
    {
        return $this->selectOptions;
    }

    protected function setSelectOptions($options)
    {
        $this->selectOptions = [];

        foreach ($options as $optionValue => $display) {
            $this->option($optionValue, $display);
        }
    }
}
