<?php

namespace Administr\Form;

trait RenderAttributesTrait
{
    public function renderAttributes(array $attrs = [])
    {
        if (count($attrs) === 0) {
            return '';
        }

        $attributes = '';
        foreach ($attrs as $attr => $value) {
            if(is_array($value)) {
                continue;
            }

            $attributes .= " {$attr}=\"{$value}\"";
        }

        return $attributes;
    }
}
