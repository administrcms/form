<?php

namespace Administr\Form\Field;

class Select extends AbstractType
{
    public function renderField(array $attributes = [])
    {
        $attrs = array_merge([
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        $options = '';
        $value = array_get($attrs, 'value');
        unset($attrs['value']);

        if (array_key_exists('values', $attrs)) {
            $values = $attrs['values'];
            unset($attrs['values']);

            foreach ($values as $optionValue => $display) {
                $optionAttrs = [];

                if($optionValue === $value) {
                    $optionAttrs['selected'] = 'selected';
                }

                $options .= (new Option($optionValue, $display, $optionAttrs))->renderField();
            }
        }

        return '<select'.$this->renderAttributes($attrs).'>'.$options.'</select>';
    }
}
