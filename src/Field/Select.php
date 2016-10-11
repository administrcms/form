<?php

namespace Administr\Form\Field;

class Select extends AbstractType
{
    protected $selectOptions = [];

    public function render(array $attributes = [], array $viewData = [])
    {
        $this->options = array_merge($this->options, $attributes);

        $value = request($this->name, $this->getOption('value'));
        unset($this->options['value']);

        if ($values = $this->getOption('values')) {
            $this->selectOptions = [];

            foreach ($values as $optionValue => $display) {
                $optionAttrs = [];

                if ($optionValue === $value) {
                    $optionAttrs['selected'] = 'selected';
                }

                $this->option($optionValue, $display, $optionAttrs);
            }
        }

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
}
