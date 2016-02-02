<?php

namespace Administr\Form\Presenters;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Submit;
use Administr\Form\RenderAttributesTrait;

class BootstrapPresenter implements Presenter
{
    use RenderAttributesTrait;

    public function render(AbstractType $field, array $error)
    {
        $attrs = [
            'class' => 'form-group'
        ];
        $fieldAttrs = [
            'class' => 'form-control'
        ];

        if( count($error) > 0 )
        {
            $attrs['class'] .= ' has-error';
        }

        if( $field instanceof Submit )
        {
            $fieldAttrs['class'] = 'btn btn-primary';
        }

        return "<div{$this->renderAttributes($attrs)}>" . "\n" .
        "{$field->renderLabel()}" . "\n" .
        "{$field->renderField($fieldAttrs)}" . "\n" .
        "<span class=\"help-block\">{$field->renderErrors($error)}</span>" . "\n" .
        "</div>";
    }
}