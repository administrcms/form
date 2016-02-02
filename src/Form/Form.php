<?php

namespace Administr\Form;

use Administr\Form\Exceptions\FormValidationException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\MessageBag;

abstract class Form implements ValidatesWhenSubmitted
{
    use RenderAttributesTrait;

    protected $options = [];

    protected $form;

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Factory
     */
    protected $validator;
    /**
     * The redirector instance.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * @var Factory
     */
    protected $validatorInstance;
    /**
     * The URI to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirect;

    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute;

    /**
     * The controller action to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectAction;
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'default';

    /**
     * The input keys that should not be flashed on redirect.
     *
     * @var array
     */
    protected $dontFlash = ['password', 'password_confirmation'];

    public function __construct(FormBuilder $form, Request $request, Factory $validator, Redirector $redirector)
    {
        $this->form = $form;
        $this->request = $request;
        $this->validator = $validator;
        $this->redirector = $redirector;
        $this->form($this->form);
    }

    /**
     * Render the form HTML.
     *
     */
    public function render()
    {
        $form = "<form{$this->renderAttributes($this->options)}>\n";
        $form .= $this->form->render($this->errors());
        $form .= "</form>\n";

        return $form;
    }

    public function errors()
    {
        $errors = $this->request->session()->get('errors');

        if(empty($errors))
        {
            return new MessageBag;
        }

        return $errors;
    }

    public function isValid()
    {
        if(!is_array($this->rules()) || count($this->rules()) === 0)
        {
            return true;
        }

        $this->validatorInstance = $this->validator->make($this->request->all(), $this->rules());

        return $this->validatorInstance->passes();
    }

    public function submitted()
    {
        return strtolower($this->request->getMethod()) !== 'get';
    }

    public function validate()
    {
        if($this->isValid() || !$this->submitted())
        {
            return;
        }

        throw new FormValidationException($this->validatorInstance, $this->response($this->validatorInstance->getMessageBag()->toArray()));
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if ($this->request->ajax() || $this->request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->request->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
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
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
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