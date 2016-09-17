<?php

namespace Administr\Form\Field;

class Text extends AbstractType
{
    public function renderField(array $attributes = [])
    {
        $attributes = array_merge($this->options, $attributes);

        $value = array_key_exists('value', $attributes) ? $attributes['value'] : null;

        $attrs = array_merge([
            'type'  => 'text',
            'id'    => $this->getName(),
            'name'  => $this->getName(),
        ], $attributes, [
            'value' => old($this->name, $value),
        ]);

        return '<input'.$this->renderAttributes($attrs).'>';
    }
}
