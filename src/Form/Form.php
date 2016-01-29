<?php

namespace Administr\Form;

abstract class Form
{
    protected $form;

    public function __construct(FormBuilder $form)
    {
        $this->form = $form;
        $this->form($this->form);
    }

    /**
     * Render the form HTML.
     *
     */
    public function render()
    {
        return $this->form->render();
    }

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Define the fields of the form
     *
     * @param FormBuilder $form
     * @return
     */
    abstract public function form(FormBuilder $form);
}