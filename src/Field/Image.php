<?php

namespace Administr\Form\Field;


class Image extends File
{
    protected $imageSrc;

    public function setSrc($src)
    {
        $this->imageSrc = $src;
        return $this;
    }

    public function renderField(array $attributes = [])
    {
        return $this->renderImage() . parent::renderField($attributes);
    }

    public function renderImage()
    {
        if(!$this->imageSrc) {
            return '';
        }

        return '<img class="administr_image_type" src="'. $this->imageSrc .'" alt="'. $this->imageSrc .'" />';
    }
}