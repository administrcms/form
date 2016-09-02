<?php

namespace Administr\Form\AssetShortcuts;

use Administr\Assets\Contracts\Shortcut;
use Asset;

class WysiwygShortcut implements Shortcut
{
    public function execute()
    {
        Asset::addJs(
            '/vendor/administr/form/tinymce/tinymce.min.js',
            10
        );

        Asset::addJs(
            '/vendor/administr/form/form.js',
            0
        );
    }
}
