<?php

namespace Administr\Form\Field;

use Administr\Form\RenderAttributesTrait;

abstract class AbstractType
{
    use RenderAttributesTrait;

    protected $name;
    protected $label;
    protected $options = [];

    public function __construct($name, $label, $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
    }

    abstract public function renderField(array $attributes = []);

    public function render(array $errors = [])
    {
        return $this->renderLabel().$this->renderField().$this->renderErrors($errors);
    }

    public function renderLabel()
    {
        return "<label for=\"{$this->name}\">{$this->label}</label>\n";
    }

    public function renderErrors(array $errors = [])
    {
        if (count($errors) === 0) {
            return '';
        }

        return implode("\n", $errors);
    }

    public function translated()
    {
        $this->options['translated'] = true;
        return $this;
    }

    public function isTranslated()
    {
        return array_key_exists('translated', $this->options) && $this->options['translated'] === true;
    }

    public function appendOption($option, $value)
    {
        $this->options = array_merge($this->options, [$option => $value]);
    }

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
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($field)
    {
        return $this->options[$field];
    }

    public function isButton()
    {
        return $this instanceof Submit || $this instanceof Reset;
    }

    public function isHidden()
    {
        return $this instanceof Hidden;
    }

    public function isCheckbox()
    {
        return $this instanceof Checkbox;
    }

    public function isRadio()
    {
        return $this instanceof Radio;
    }

    public function __toString()
    {
        return $this->render();
    }
}
