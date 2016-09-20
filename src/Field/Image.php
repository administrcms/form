<?php

namespace Administr\Form\Field;

use Administr\Form\Contracts\Image as ImageContract;

class Image extends File implements ImageContract
{
    protected $src = null;

    public function render(array $attributes = [])
    {
        return parent::render($attributes);
    }

    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }

    public function getSrc()
    {
        return $this->src;
    }
}