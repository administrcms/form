<?php

namespace Administr\Form\Presenters;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Radio;
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

        if ($field->isButton()) {
            $fieldAttrs['class'] = 'btn btn-primary';
        }

        if ($field->isCheckbox()) {
            $attrs['class'] = str_replace('form-group', 'checkbox', $attrs['class']);
            $fieldAttrs['class'] = '';

            if (array_key_exists('value', $field->getOptions()) && (bool) $field->getOption('value')) {
                $fieldAttrs['checked'] = 'checked';
            }
        }

        if ($field->isRadio()) {
            $attrs['class'] = str_replace('form-group', 'radio', $attrs['class']);
            $fieldAttrs['class'] = '';
        }

        $presentation = "<div{$this->renderAttributes($attrs)}>"."\n";
        $presentation .= "{$field->renderLabel()}";
        $presentation .= "{$field->renderField($fieldAttrs)}"."\n";

        if (!$field->isButton() && !$field->isHidden()) {
            $presentation .= "<span class=\"help-block\">{$field->renderErrors($error)}</span>"."\n";
        }

        $presentation .= '</div>';

        return $presentation;
    }
}
