# Form Builder for the administr package

[![Build Status](https://travis-ci.org/administrcms/form.svg?branch=master)](https://travis-ci.org/administrcms/form)
[![Code Climate](https://codeclimate.com/github/administrcms/form/badges/gpa.svg)](https://codeclimate.com/github/administrcms/form)
[![Test Coverage](https://codeclimate.com/github/administrcms/form/badges/coverage.svg)](https://codeclimate.com/github/administrcms/form/coverage)

Work-in-progress.

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