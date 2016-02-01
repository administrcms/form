<?php

namespace Administr\Form;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Email;
use Administr\Form\Field\Option;
use Administr\Form\Field\Password;
use Administr\Form\Field\Radio;
use Administr\Form\Field\Select;
use Administr\Form\Field\Submit;
use Administr\Form\Field\Text;
use Administr\Form\Field\Textarea;
use Administr\Form\Exceptions\InvalidField;

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
        $this->fields[$field->getName()] = $field;
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
     * Add an email field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function email($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Email($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a password field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function password($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Password($fieldName, $fieldLabel, $options));
    }

    /**
     * Add a submit button.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     * @return FormBuilder
     */
    public function submit($fieldName, $fieldLabel, $options = [])
    {
        return $this->add(new Submit($fieldName, $fieldLabel, $options));
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

    public function get($fieldName)
    {
        if( array_key_exists($fieldName, $this->fields) )
        {
            return $this->fields[$fieldName];
        }

        throw new InvalidField("The requested field index [{$fieldName}] has not been defined.");
    }

    public function __get($name)
    {
        return $this->get($name);
    }
}