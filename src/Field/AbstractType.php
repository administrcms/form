<?php

namespace Administr\Form\Field;

use Administr\Form\RenderAttributesTrait;

abstract class AbstractType
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
        $this->setName($name);
        $this->setLabel($label);
        $this->setView("administr/form::{$this->type()}");

        if($options instanceof \Closure)
        {
            call_user_func($options, $this);
        }

        if(is_array($options))
        {
            $options = $this->optionsToMethods($options);
            $this->setOptions($options);
        }
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
        $this->options = array_merge($this->options, $attributes);

        $value = request($this->name, $this->getOption('value'));

        $this->setValue( old($this->name, $value) );

        if($this->isSkipped()) {
            return;
        }

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

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return mixed
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
        return array_get($this->options, $option, $default);
    }

    /**
     * Set single option.
     *
     * @param $option
     * @param $value
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
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
        return $this->renderAttributes($this->options);
    }

    /**
     * Is this field a type of button.
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isButton()
    {
        return $this instanceof Submit || $this instanceof Reset;
    }

    /**
     * Is this a hidden field.
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return $this instanceof Hidden;
    }

    /**
     * Is this a checkbox field.
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isCheckbox()
    {
        return $this instanceof Checkbox;
    }

    /**
     * Is this a radio field.
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isRadio()
    {
        return $this instanceof Radio;
    }

    /**
     * Whether a radio or checkbox should be checked.
     *
     * @param mixed $value
     *
     * @return bool
     * @codeCoverageIgnore
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
        return strtolower( str_replace( 'Administr\\Form\\Field\\', '', get_called_class() ) );
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
     */
    public function skipIf($condition)
    {
        if(!is_bool($condition)) {
            return;
        }

        $this->skipIf = $condition;
    }

    public function isSkipped()
    {
        return $this->skipIf;
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

            call_user_func([$this, $name], $value);
            unset($options[$name]);
        }

        return $options;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->render();
    }
}
