<?php

namespace Administr\Form;


use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->afterResolving(function(ValidatesWhenSubmitted $form){
            $form->validate();
        });
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