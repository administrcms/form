<?php

namespace Administr\Form\Field;

class Text extends AbstractType
{
    public function renderField(array $attributes = [])
    {
        $value = array_key_exists('value', $attributes) ? $attributes['value'] : null;

        $attrs = array_merge([
            'type'  => 'text',
            'id'    => $this->name,
            'name'  => $this->name,
            'value' => old($this->name, $value),
        ], $this->options, $attributes);

        return '<input'.$this->renderAttributes($attrs).'>';
    }
}
