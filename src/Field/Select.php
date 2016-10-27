<?php

namespace Administr\Form\Field;

class Select extends AbstractType
{
    protected $selectOptions = [];

    public function render(array $attributes = [], array $viewData = [])
    {
        $this->options = array_merge($this->options, $attributes);

        $value = old(str_replace('[]', '', $this->name), $this->getOption('value'));
        unset($this->options['value']);

        $this->setSelectOptions($value);

        return parent::render($attributes, $viewData);
    }

    public function option($value, $display, $options = null)
    {
        $this->selectOptions[] = new Option($value, $display, $options);
        return $this;
    }

    public function options()
    {
        return $this->selectOptions;
    }

    protected function setSelectOptions($value)
    {
        if (!$values = $this->getOption('values')) {
            return;
        }

        $this->selectOptions = [];

        foreach ($values as $optionValue => $display) {
            $optionAttrs = [];

            if ($optionValue == $value || is_array($value) && in_array($optionValue, $value)) {
                $optionAttrs['selected'] = 'selected';
            }

            $this->option($optionValue, $display, $optionAttrs);
        }
    }
}
