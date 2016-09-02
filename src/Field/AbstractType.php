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

    public function __construct($name, $label, $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
    }

    abstract public function renderField(array $attributes = []);

    /**
     * Default render of field with its label and errors.
     *
     * @param array $errors
     *
     * @return string
     */
    public function render(array $errors = [])
    {
        return $this->renderLabel().$this->renderField().$this->renderErrors($errors);
    }

    /**
     * Default label rendering for a field.
     *
     * @return string
     */
    public function renderLabel()
    {
        return "<label for=\"{$this->name}\">{$this->label}</label>\n";
    }

    /**
     * Default rendering of the errors for a field.
     *
     * @param array $errors
     *
     * @return string
     */
    public function renderErrors(array $errors = [])
    {
        if (count($errors) === 0) {
            return '';
        }

        return implode("\n", $errors);
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
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Get an option.
     *
     * @param $option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return array_get($this->options, $option);
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

    /**
     * Is this field a type of button.
     *
     * @return bool
     */
    public function isButton()
    {
        return $this instanceof Submit || $this instanceof Reset;
    }

    /**
     * Is this a hidden field.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this instanceof Hidden;
    }

    /**
     * Is this a checkbox field.
     *
     * @return bool
     */
    public function isCheckbox()
    {
        return $this instanceof Checkbox;
    }

    /**
     * Is this a radio field.
     *
     * @return bool
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
     */
    public function isChecked($value)
    {
        return $this->value == $value;
    }

    public function __toString()
    {
        return $this->render();
    }
}
