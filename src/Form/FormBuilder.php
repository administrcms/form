<?php

namespace Administr\Form;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Option;
use Administr\Form\Field\Radio;
use Administr\Form\Field\Select;
use Administr\Form\Field\Text;
use Administr\Form\Field\Textarea;

class FormBuilder
{
    /**
     * @var array
     */
    private $fields = [];


    /**
     * Add a field to the form.
     *
     * @param AbstractType $field
     * @return $this
     */
    public function add(AbstractType $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    /**
     * Add a text field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function text($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Text($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a textarea field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function textarea($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Textarea($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a radio field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function radio($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Radio($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a checkbox field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function checkbox($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Checkbox($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a select field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function select($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Select($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a option field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function option($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Option($fieldName, $fieldLabel, $options));
    }

    /**
     * Basic rendering of the form.
     *
     * @return string
     */
    public function render()
    {
        $form = '';

        foreach($this->fields as $field)
        {
            $form .= $field->render();
        }

        return $form;
    }

    /**
     * Get the fields in the form.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}