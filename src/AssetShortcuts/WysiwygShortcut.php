<?php

namespace Administr\Form\AssetShortcuts;

use Administr\Assets\Contracts\Shortcut;
use Asset;

class WysiwygShortcut implements Shortcut
{
    public function exexute()
    {
        Asset::addJs(
            url('vendor/administr/form/tinymce/tinymce.min.js')
        );

        Asset::addJs(
            url('vendor/administr/form/form.js')
        );
    }
}