<?php

namespace Administr\Form;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\Request;

abstract class Form
{
    use RenderAttributesTrait;

    protected $options = [];

    protected $form;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var Factory
     */
    private $validator;

    public function __construct(FormBuilder $form, Request $request, Factory $validator)
    {
        $this->form = $form;
        $this->request = $request;
        $this->validator = $validator;
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

    public function isValid()
    {
        if(!is_array($this->rules()) || count($this->rules()) === 0)
        {
            return true;
        }

        $v = $this->validator->make($this->request->all(), $this->rules());

        return $v->passes();
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