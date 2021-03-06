<?php

namespace Administr\Form;

use Administr\Form\Contracts\ValidatesWhenSubmitted;
use Administr\Form\Exceptions\FormValidationException;
use Administr\Form\Field\Field;
use Administr\Localization\Models\Language;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;

abstract class Form implements ValidatesWhenSubmitted
{
    use RenderAttributesTrait;

    protected $options = [];

    /**
     * @var FormBuilder
     */
    protected $builder;

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

    public function __construct(FormBuilder $builder, Request $request, Factory $validator, Redirector $redirector)
    {
        $this->builder = $builder;
        $this->request = $request;
        $this->validator = $validator;
        $this->redirector = $redirector;

        $this->builder()->setValidationRules($this->getParsedRules());

//        $this->form($this->builder);
    }

    /**
     * Getter for FormBuilder instance.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * Render the form HTML.
     * @param array $viewData
     * @return string
     */
    public function render(array $viewData = [])
    {
        $form = $this->open();
        $form .= $this->builder()->render($viewData);
        $form .= $this->close();

        session()->forget('administr.form.rendered');

        return $form;
    }

    /**
     * @return string
     */
    public function open()
    {
        $this->form($this->builder);

        $this
            ->setEnctype()
            ->addTokenField();

        // To simulate a put requrest with Laravel,
        // we need to add a hidden field for the method

        $this->builder()->hidden('_method', Arr::get($this->options, 'method'));

        if (Arr::get($this->options, 'method') == 'put') {
            $this->options['method'] = 'post';
        }

        return "<form{$this->renderAttributes($this->options)}>\n";
    }

    /**
     * @return string
     */
    public function close()
    {
        return "</form>\n";
    }

    /**
     * @param $name
     * @return Field
     * @codeCoverageIgnore
     */
    public function field($name)
    {
        return $this->builder()->get($name);
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function fields()
    {
        return $this->builder()->fields();
    }

    /**
     * @param $name
     * @param array $attributes
     * @param array $viewData
     * @return string
     * @codeCoverageIgnore
     */
    public function renderField($name, array $attributes = [], array $viewData = [])
    {
        return $this->builder()->renderField($name, $attributes, $viewData);
    }

    public function isValid()
    {
        if (!is_array($this->rules()) || count($this->rules()) === 0) {
            return true;
        }

        $this->validatorInstance = $this->validator->make(
            $this->request->all(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        return $this->validatorInstance->passes();
    }

    /**
     * @codeCoverageIgnore
     */
    public function submitted()
    {
        return ! $this->request->isMethod('get');
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
     * Set the data source on the form builder.
     *
     * @param array|Model|Translatable $dataSource
     *
     * @return $this
     * @codeCoverageIgnore
     */
    public function dataSource($dataSource = null)
    {
        $this->builder()->dataSource($dataSource);

        return $this;
    }

    /**
     * @param $field
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function has($field)
    {
        return $this->request->has($field);
    }

    /**
     * @param $field
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function get($field)
    {
        return html_entity_decode($this->request->get($field));
    }

    /**
     * @codeCoverageIgnore
     */
    public function all()
    {
        return array_map([$this, 'removeEntities'], $this->request->all());
    }

    /**
     * @return Request
     * @codeCoverageIgnore
     */
    public function request()
    {
        return $this->request;
    }

    public function translated()
    {
        $languages = Language::pluck('id');

        $this->form($this->builder);

        $languageFields = array_filter($this->fields(), function (Field $field) {
            return $field->isTranslated();
        });

        if($translated = Arr::get($this->fields(), 'translated')) {
            $languageFields += $translated->builder()->fields();
        }

        $translated = [];

        foreach ($languages as $language_id) {
            $translated[$language_id] = [];
            foreach ($this->all() as $field => $value) {
                if (array_key_exists($field, $languageFields)) {
                    $translated[$language_id][$field] = $value[$language_id];
                    continue;
                }
            }
        }

        return $translated;
    }

    /**
     * Skip fields from rendering.
     *
     * @codeCoverageIgnore
     */
    public function skip()
    {
        return $this->builder()->skip(func_get_args());
    }

    /**
     * Set the enctype attribute.
     */
    public function setEnctype()
    {
        if(array_key_exists('enctype', $this->options)) {
            return $this;
        }

        $hasFile = false;
        $isFile = function(Field $field) {
            return $field->is('file');
        };

        foreach($this->fields() as $field)
        {
            if($field->is('group')) {
                foreach($field->builder()->fields() as $f)
                {
                    $hasFile = $isFile($f);

                    if($hasFile) {
                        break;
                    }
                }
            }

            if($hasFile) {
                break;
            }

            $hasFile = $isFile($field);
        }

        $this->options['enctype'] = $hasFile ? 'multipart/form-data' : 'application/x-www-form-urlencoded';

        return $this;
    }

    /**
     * Add Laravel's csrf token.
     */
    public function addTokenField()
    {
        if (array_key_exists('_token', $this->fields()) || Arr::get($this->options, 'method') == 'get') {
            return $this;
        }

        $this->builder()->hidden('_token', csrf_token());

        return $this;
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

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->render();
    }

    public function removeEntities($val)
    {
        if (is_string($val)) {
            return html_entity_decode($val);
        }

        if (is_array($val)) {
            $val = array_map([$this, 'removeEntities'], $val);
        }

        return $val;
    }

    /**
     * Parse the validation rules into an array,
     * containing field => rules, where rules is an
     * array of rule => params.
     *
     * @return array
     */
    public function getParsedRules()
    {
        $transformedRules = $this->validator->make([], $this->rules())->getRules();

        foreach($transformedRules as $field => $rules) {
            foreach($rules as $key => $rule) {
                $parameters = [];

                if (strpos($rule, ':') !== false) {
                    list($rule, $parameter) = explode(':', $rule, 2);

                    $parameters = str_getcsv($parameter);
                }

                $transformedRules[$field][$rule] = $parameters;
                unset($transformedRules[$field][$key]);
            }
        }

        return $transformedRules;
    }

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Define custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Define custom attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Define the fields of the form.
     *
     * @param FormBuilder $builder
     *
     * @return
     */
    abstract public function form(FormBuilder $builder);
}
