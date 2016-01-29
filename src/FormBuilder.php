<?php

namespace Administr\Form;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

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