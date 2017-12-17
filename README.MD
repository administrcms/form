# Form Builder for the Administr package

[![Build Status](https://travis-ci.org/administrcms/form.svg?branch=master)](https://travis-ci.org/administrcms/form)
[![Code Climate](https://codeclimate.com/github/administrcms/form/badges/gpa.svg)](https://codeclimate.com/github/administrcms/form)
[![Test Coverage](https://codeclimate.com/github/administrcms/form/badges/coverage.svg)](https://codeclimate.com/github/administrcms/form/coverage)

Work-in-progress.

# Installation

* Install using composer:
```
composer require administrcms/form
```

* Register the Service Provider (in config/app.php or in app/Providers/AppServiceProvider.php):
```php
// in app.php
'providers' => [
    // ...
    Administr\Form\FormServiceProvider::class,
    // ...
],

// in AppServiceProvider
public function register()
{
    $this->app->register(\Administr\Form\FormServiceProvider::class);
}

```

* Publish assets, configs, migrations and etc.
```
php artisan vendor:publish --provider="Administr\Form\FormServiceProvider"
```

# Creating forms
There is a command available, which will generate a basic scaffold of a Form class for you.

`php artisan administr:form MyForm`

Or you can just create a new class which extends the `Administr\Form\Form` class and implement the two abstract methods - rules and form.

# Form look and feel

By default the form fields are just basic html, without any styling. When you publish the assets which are connected to the package, the views will be exported to `resources/views/vendor/administrcms/form`, where you can modify them to adopt the theme of your application.

# Radio groups

```php
<?php

namespace App\Http\Forms;

use Administr\Form\Field\RadioGroup;
use Administr\Form\Form;
use Administr\Form\FormBuilder;

class TeamForm extends Form
{

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|max:100',
        ];
    }

    /**
     * Define the fields of the form.
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form
            ->text('name', 'Name', ['translated' => true])
            ->radioGroup('is_visible', 'Is Visible', function(RadioGroup $group) {
                $group
                    ->radio('да', ['value' => 1])
                    ->radio('не', ['value' => 0]);
            })
            ->submit('save', 'Save');
    }
}
```