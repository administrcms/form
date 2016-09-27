<?php

namespace Administr\Form\Field;

class Select extends AbstractType
{
    protected $selectOptions = [];

    public function render(array $attributes = [])
    {
        $this->options = array_merge($this->options, $attributes);

        $value = $this->getOption('value');
        unset($this->options['value']);

        if ($values = $this->getOption('values')) {
            $this->selectOptions = [];

            foreach ($values as $optionValue => $display) {
                $optionAttrs = [];

                if ($optionValue === $value) {
                    $optionAttrs['selected'] = 'selected';
                }

                $this->selectOptions[] = new Option($optionValue, $display, $optionAttrs);
            }
        }

        return parent::render();
    }

    public function options()
    {
        return $this->selectOptions;
    }
}
