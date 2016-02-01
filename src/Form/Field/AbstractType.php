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

    abstract public function renderField($attributes = []);
    abstract public function renderErrors();

    public function render()
    {
        return $this->renderLabel() . $this->renderField() . $this->renderErrors();
    }

    public function renderLabel()
    {
        return '<label for="'.$this->name.'">' . $this->label . '</label>';
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
}