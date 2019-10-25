<?php

namespace Administr\Form\Field;

use Administr\Form\RenderAttributesTrait;
use Illuminate\Support\Arr;

abstract class Field
{
    use RenderAttributesTrait;

    protected $name;
    protected $label;
    protected $options = [];
    protected $value = null;
    protected $view;

    protected $skipIf = false;

    public function __construct($name, $label, $options = null)
    {
        $this
            ->setName($name)
            ->setLabel($label)
            ->setView("administr/form::{$this->type()}");

        $this->executeOptions($options);
    }

    /**
     * Default render of field with its label and errors.
     *
     * @param array $attributes
     * @param array $viewData
     *
     * @return string
     */
    public function render(array $attributes = [], array $viewData = [])
    {
        if($this->isSkipped()) {
            return;
        }

        $this->options = array_merge($this->options, $attributes);

        if(is_null($this->getValue())) {
            $value = request($this->getEscapedName(), $this->getOption('value'));
            $this->setValue(old($this->getEscapedName(), $value));
        }

        $this->renderCountInrement();

        return view($this->getView(), array_merge([
            'field' => $this
        ], $viewData));
    }

    /**
     * Shortcut to set the translated option.
     *
     * @return $this
     */
    public function translated()
    {
        $this->options['translated'] = true;

        return $this;
    }

    /**
     * Check if the field is translated.
     *
     * @return bool
     */
    public function isTranslated()
    {
        return $this->getOption('translated') === true;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $escapeToken
     * @return string
     */
    public function getEscapedName($escapeToken = '.')
    {
        $withoutEmptyBrackets = str_replace('[]', '', $this->name);

        return str_replace(']', '', str_replace('[', $escapeToken, $withoutEmptyBrackets));
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Option for this field.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Append an option for the field.
     *
     * @param $option
     * @param $value
     *
     * @return $this
     */
    public function appendOption($option, $value)
    {
        $this->options = array_merge($this->options, [$option => $value]);

        return $this;
    }

    /**
     * Append multiple options at once.
     *
     * @param array $options
     * @return $this
     */
    public function appendOptions(array $options)
    {
        foreach($options as $option => $value) {
            $this->appendOption($option, $value);
        }

        return $this;
    }

    /**
     * Get an option.
     *
     * @param $option
     * @param null $default
     *
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return Arr::get($this->options, $option, $default);
    }

    /**
     * Set single option.
     *
     * @param $option
     * @param $value
     * @return $this
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        foreach($options as $option => $value) {
            $this->setOption($option, $value);
        }

        return $this;
    }

    /**
     * Set the value for a given field.
     *
     * @param $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function attributes()
    {
        $options = $this->getOptions();

        if(
            array_key_exists('value', $options)
            && (strlen($options['value']) === 0 || is_null($options['value']))
        ) {
            unset($options['value']);
        }

        return $this->renderAttributes($options);
    }

    public function is($types)
    {
        if(!is_array($types)) {
            $types = (array)$types;
        }

        foreach($types as $type) {
            $toType = 'Administr\Form\Field\\' . ucfirst($type);

            if($this instanceof $type || $this instanceof $toType) {
                return true;
            }
        }

        return false;
    }

    /**
     * Whether a radio or checkbox should be checked.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isChecked($value)
    {
        return $this->value == $value;
    }

    /**
     * Get the type of the field.
     *
     * Administr\Form\Field\Text -> text
     *
     * @return string
     */
    public function type()
    {
        return strtolower( str_replace( 'Administr\Form\Field\\', '', get_called_class() ) );
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * The view file for this field.
     *
     * @param string $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Skip field render if given condition is true.
     *
     * @param boolean $condition
     * @return $this
     */
    public function skipIf($condition)
    {
        if(!is_bool($condition)) {
            return $this;
        }

        $this->skipIf = $condition;

        return $this;
    }

    public function isSkipped()
    {
        return $this->skipIf;
    }

    /**
     * Number of times this field has been rendered.
     *
     * @codeCoverageIgnore
     * @return int
     */
    public function renderCount()
    {
        return session("administr.form.rendered.{$this->getView()}", 0);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function renderCountInrement()
    {
        $sessionKey = "administr.form.rendered.{$this->getView()}";
        session([$sessionKey => session($sessionKey) + 1]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param array $options
     * @return array
     */
    protected function optionsToMethods(array $options)
    {
        foreach($options as $name => $value)
        {
            if(! method_exists($this, $name) ) {
                continue;
            }

            if(!is_array($value)) {
                $value = [$value];
            }

            call_user_func_array([$this, $name], $value);
            unset($options[$name]);
        }

        return $options;
    }

    /**
     * @param $options
     */
    protected function executeOptions($options)
    {
        if ($options instanceof \Closure) {
            call_user_func($options, $this);
        }

        if (is_array($options)) {
            $options = $this->optionsToMethods($options);
            $this->setOptions($options);
        }
    }
}
