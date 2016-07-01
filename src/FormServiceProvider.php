<?php

namespace Administr\Form;

use Administr\Form\AssetShortcuts\WysiwygShortcut;
use Illuminate\Support\ServiceProvider;
use Asset;

/**
 * Class FormServiceProvider.
 *
 * @codeCoverageIgnore
 */
class FormServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->afterResolving(function (ValidatesWhenSubmitted $form) {
            $form->validate();
        });

        Asset::shortcuts([
            'wysiwyg'   => WysiwygShortcut::class,
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/administr/form'),
        ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
