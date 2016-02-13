<?php

namespace Administr\Form\Field;

class Textarea extends AbstractType
{
    public function renderField(array $attributes = [])
    {
        $attrs = array_merge([
            'id'    => $this->name,
            'name'  => $this->name,
        ], $this->options, $attributes);

        $value = null;
        if (array_key_exists('value', $attrs)) {
            $value = $attrs['value'];
            unset($attrs['value']);
        }

        return '<textarea'.$this->renderAttributes($attrs).'>'.old($this->name, $value).'</textarea>';
    }
}
