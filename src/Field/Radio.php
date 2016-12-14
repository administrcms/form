<?php

namespace Administr\Form\Field;

class Radio extends Text
{
    public function render(array $attributes = [], array $viewData = [])
    {
        $this->options = array_merge($this->getOptions(), $attributes);

        $value = request($this->name, $this->getOption('value'));

        if ($this->isChecked($value)) {
            $this->options['checked'] = 'checked';
        }

        $this->setValue($value);

        if($this->isSkipped()) {
            return;
        }

        return view($this->getView(), array_merge([
            'field' => $this
        ], $viewData));
    }
}
