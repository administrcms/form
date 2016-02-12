<?php

namespace Administr\Form;

use Administr\Form\Exceptions\FormValidationException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ViewErrorBag;

abstract class Form implements ValidatesWhenSubmitted
{
    use RenderAttributesTrait;

    protected $options = [];

    /**
     * @var FormBuilder
     */
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
     */
    public function render()
    {
        $form = $this->getFormOpen();
        $form .= $this->form->render($this->errors());
        $form .= $this->getFormClose();

        return $form;
    }

    /**
     * @return string
     */
    public function getFormOpen()
    {
        if (array_key_exists('method', $this->options) && $this->options['method'] == 'put') {
            $this->options['method'] = 'post';
            $this->form->hidden('_method', 'put');
        }

        return "<form{$this->renderAttributes($this->options)}>\n";
    }

    /**
     * @return string
     */
    public function getFormClose()
    {
        return "</form>\n";
    }

    public function field($name)
    {
        return $this->form->get($name);
    }

    public function fields()
    {
        return $this->form->getFields();
    }

    public function errors()
    {
        $errors = $this->request->session()->get('errors');

        if (empty($errors)) {
            return new ViewErrorBag();
        }

        // @codeCoverageIgnoreStart
        return $errors;
        // @codeCoverageIgnoreEnd
    }

    public function isValid()
    {
        if (!is_array($this->rules()) || count($this->rules()) === 0) {
            return true;
        }

        $this->validatorInstance = $this->validator->make($this->request->all(), $this->rules());

        return $this->validatorInstance->passes();
    }

    /**
     * @codeCoverageIgnore
     */
    public function submitted()
    {
        return strtolower($this->request->getMethod()) !== 'get';
    }

    /**
     * @codeCoverageIgnore
     */
    public function validate()
    {
        if ($this->isValid() || !$this->submitted()) {
            return;
        }

        throw new FormValidationException(
            $this->validatorInstance,
            $this->response($this->validatorInstance->getMessageBag()->toArray())
        );
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @codeCoverageIgnore
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

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     * @codeCoverageIgnore
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

    public function setDataSource($dataSource)
    {
        $this->form->setDataSource($dataSource);

        return $this;
    }

    public function __set($name, $value)
    {
        $this->options[$name] = strtolower($value);
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->options)) {
            return $this->request->get($name);
        }

        return $this->options[$name];
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Define the fields of the form.
     *
     * @param FormBuilder $form
     *
     * @return
     */
    abstract public function form(FormBuilder $form);
}
