<?php

namespace Administr\Form;

use Administr\Form\Exceptions\InvalidField;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ViewErrorBag;

class FormBuilder
{
    /*
     * @var \Administr\Form\Presenters\Presenter
     */
    public $presenter = \Administr\Form\Presenters\BootstrapPresenter::class;

    /**
     * @var array
     */
    private $fields = [];

    private $dataSource = null;

    /**
     * Add a field to the form.
     *
     * @param AbstractType $field
     *
     * @return $this
     */
    public function add(AbstractType $field)
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * Basic rendering of the form.
     *
     * @param ViewErrorBag $errors
     *
     * @return string
     */
    public function render(ViewErrorBag $errors = null)
    {
        $form = '';

        foreach ($this->fields as $name => $field) {
            if ($value = $this->getValue($name)) {
                $field->appendOption('value', $value);
            }

            $error = !empty($errors) && $errors->has($name) ? $errors->get($name) : [];
            $form .= $this->present($field, $error);
        }

        return $form;
    }

    public function present(AbstractType $field, array $error = [])
    {
        if (empty($this->presenter) || !class_exists($this->presenter)) {
            return $field->render($error)."\n";
        }

        $presenter = new $this->presenter();

        return $presenter->render($field, $error);
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
        if (array_key_exists($fieldName, $this->fields)) {
            return $this->fields[$fieldName];
        }

        throw new InvalidField("The requested field index [{$fieldName}] has not been defined.");
    }

    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getValue($field)
    {
        $ds = $this->dataSource;

        if ($this->dataSource instanceof Model) {
            $ds = $this->dataSource->toArray();
        }

        if (is_array($ds) && array_key_exists($field, $ds)) {
            return $ds[$field];
        }

        return;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Add a field of given type. Example - text, email, password, etc.
     *
     * @param $name
     * @param array $args
     *
     * @return $this
     */
    public function __call($name, array $args)
    {
        $class = 'Administr\\Form\\Field\\'.studly_case($name);

        if (!class_exists($class)) {
            $class = Text::class;
        }

        $reflector = new \ReflectionClass($class);

        $this->add($reflector->newInstanceArgs($args));

        return $this;
    }
}
