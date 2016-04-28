<?php

namespace Administr\Form;

use Administr\Form\Exceptions\InvalidField;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;
use Administr\Localization\Models\Language;
use Administr\Localization\Models\Translatable;
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

    private $skips = [];

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

        $fields = array_filter($this->fields, function(AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && !$field->isTranslated();
        });

        foreach ($fields as $name => $field) {
            if ($value = $this->getValue($name)) {
                $field->appendOption('value', $value);
            }

            if($field->isButton()) {
                $form .= $this->renderTranslated();
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

    public function renderTranslated()
    {
        $tabs = '';
        $panels = '';
        $fields = array_filter($this->fields, function(AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && $field->isTranslated();
        });

        if(count($fields) === 0) {
            return '';
        }

        foreach(Language::all() as $language) {
            $tabs .= '<li role="presentation"><a href="#'.$language->name.'" aria-controls="'.$language->name.'" role="tab" data-toggle="tab">'.$language->name.'</a></li>';

            $panels .= '<div role="tabpanel" class="tab-pane" id="'.$language->name.'">';
            foreach ($fields as $name => $field) {
                $field = clone $field;
                $field->setName("{$field->getName()}[{$language->id}]");

                if ($value = $this->getValue($name, $language->id)) {
                    $field->appendOption('value', $value);
                }

                $error = !empty($errors) && $errors->has($name) ? $errors->get($name) : [];
                $panels .= $this->present($field, $error);
            }
            $panels .= '</div>';
        }

        return '<div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
          '.$tabs.'
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
          '.$panels.'
          </div>
        </div>';
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

    public function getValue($field, $language_id = 0)
    {
        $ds = $this->dataSource;

        if ($this->dataSource instanceof Translatable && $language_id > 0) {
            $ds = $this->dataSource->translate($language_id);
            return array_get($ds, $field);
        }

        if ($this->dataSource instanceof Model) {
            $ds = $this->dataSource->toArray();
        }

        if (is_array($ds) && array_key_exists($field, $ds)) {
            return array_get($ds, $field);
        }

        return;
    }

    public function skip()
    {
        $args = func_get_args();

        if(is_array($args)) {
            $args = array_flatten($args);
        }

        if(count($args) == 1 && is_string($args[0])) {
            $args = (array)$args[0];
        }

        $this->skips = $args;
        return $this;
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
