<?php

namespace Administr\Form;

abstract class Form
{
    use RenderAttributesTrait;

    protected $options = [];

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
        $form = "<form{$this->renderAttributes($this->options)}>\n";
        $form .= $this->form->render();
        $form .= "</form>\n";

        return $form;
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function __get($name)
    {
        if( !array_key_exists($name, $this->options) )
        {
            return null;
        }

        return $this->options[$name];
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