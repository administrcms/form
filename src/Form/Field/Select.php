<?php

namespace Administr\Form\Field;


class Select extends AbstractType
{
    public function renderField($attributes = [])
    {
        $attrs = array_merge([
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        $options = '';
        if(array_key_exists('value', $attrs))
        {
            $value = $attrs['value'];
            unset($attrs['value']);

            foreach($value as $value => $display)
            {
                $options .= (new Option($value, $display))->renderField();
            }
        }

        return '<select' . $this->renderAttributes($attrs) . '>' . $options . '</select>';
    }
}