<?php

namespace Administr\Form\Presenters;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Hidden;
use Administr\Form\Field\Radio;
use Administr\Form\Field\Reset;
use Administr\Form\Field\Submit;
use Administr\Form\RenderAttributesTrait;

class BootstrapPresenter implements Presenter
{
    use RenderAttributesTrait;

    public function render(AbstractType $field, array $error = [])
    {
        $attrs = [
            'class' => 'form-group',
        ];
        $fieldAttrs = [
            'class' => 'form-control',
        ];

        if (count($error) > 0) {
            $attrs['class'] .= ' has-error';
        }

        if ($this->isButton($field)) {
            $fieldAttrs['class'] = 'btn btn-primary';
        }

        if ($this->isCheckbox($field)) {
            $attrs['class'] = str_replace('form-group', 'checkbox', $attrs['class']);
            $fieldAttrs['class'] = '';

            if (array_key_exists('value', $field->getOptions()) && (bool) $field->getOption('value')) {
                $fieldAttrs['checked'] = 'checked';
            }
        }

        if ($this->isRadio($field)) {
            $attrs['class'] = str_replace('form-group', 'radio', $attrs['class']);
            $fieldAttrs['class'] = '';
        }

        $presentation = "<div{$this->renderAttributes($attrs)}>"."\n";
        $presentation .= "{$field->renderLabel()}";
        $presentation .= "{$field->renderField($fieldAttrs)}"."\n";

        if (!$this->isButton($field) && !$this->isHidden($field)) {
            $presentation .= "<span class=\"help-block\">{$field->renderErrors($error)}</span>"."\n";
        }

        $presentation .= '</div>';

        return $presentation;
    }

    protected function isButton(AbstractType $field)
    {
        return $field instanceof Submit || $field instanceof Reset;
    }

    protected function isHidden(AbstractType $field)
    {
        return $field instanceof Hidden;
    }

    protected function isCheckbox(AbstractType $field)
    {
        return $field instanceof Checkbox;
    }

    protected function isRadio(AbstractType $field)
    {
        return $field instanceof Radio;
    }
}
