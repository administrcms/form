<?php

namespace Administr\Form;

use Administr\Form\Contracts\ImageFieldSource;
use Administr\Form\Exceptions\InvalidField;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Image;
use Administr\Form\Field\RadioGroup;
use Administr\Form\Field\Text;
use Administr\Localization\Models\Language;
use Administr\Localization\Models\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ViewErrorBag;

/**
 * Class FormBuilder.
 *
 * @method text($name, $label, array $options)
 * @method password($name, $label, array $options)
 * @method textarea($name, $label, array $options)
 * @method email($name, $label, array $options)
 * @method file($name, $label, array $options)
 * @method hidden($name, $label, array $options)
 * @method checkbox($name, $label, array $options)
 * @method radio($name, $label, array $options)
 * @method select($name, $label, array $options)
 * @method wysiwyg($name, $label, array $options)
 * @method submit($name, $label, array $options)
 * @method reset($name, $label, array $options)
 *
 */
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

    /**
     * @var array
     */
    private $skips = [];

    /**
     * @var null|array|Model|Translatable
     */
    private $dataSource = null;

    /**
     * Avoid rendering the translation fields twice.
     *
     * @var bool
     */
    private $translationRendered = false;

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
     * Define a group of radios.
     *
     * @param $name
     * @param $label
     * @param \Closure $definition
     *
     * @return $this
     */
    public function radioGroup($name, $label, \Closure $definition)
    {
        $this->fields[$name] = new RadioGroup($name, $label, $definition);

        return $this;
    }

    /**
     * Render form fields.
     *
     * @param ViewErrorBag $errors
     *
     * @return string
     */
    public function render(ViewErrorBag $errors = null)
    {
        $form = '';

        $fields = array_filter($this->fields, function (AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && !$field->isTranslated();
        });

        $fieldsCount = count($fields);
        $renderedFieldsCount = 1;

        foreach ($fields as $name => $field) {
            $this->setValue($field);

            if ($field->isButton() || $fieldsCount === $renderedFieldsCount && !$this->translationRendered) {
                $form .= $this->renderTranslated();
            }

            $error = !empty($errors) && $errors->has($name) ? $errors->get($name) : [];
            $form .= $this->present($field, $error);

            $renderedFieldsCount += 1;
        }

        return $form;
    }

    /**
     * If a presenter class has been set,
     * render the field using its presentation,
     * otherwise call the normal render.
     *
     * @param AbstractType $field
     * @param array        $error
     *
     * @return string
     */
    public function present(AbstractType $field, array $error = [])
    {
        if (empty($this->presenter) || !class_exists($this->presenter)) {
            return $field->render($error)."\n";
        }

        return (new $this->presenter())->render($field, $error);
    }

    /**
     * Render a tabs container with available languages
     * and the fields that contain translatable data.
     *
     * @return string
     */
    public function renderTranslated()
    {
        $this->translationRendered = true;

        $firstTab = true;
        $tabs = '';
        $panels = '';
        $fields = array_filter($this->fields, function (AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && $field->isTranslated();
        });

        if (count($fields) === 0) {
            return '';
        }

        foreach (Language::all() as $language) {
            $tabs .= '<li role="presentation" class="'.($firstTab ? 'active' : '').'">
                        <a href="#'.$language->name.'" aria-controls="'.$language->name.'" role="tab" data-toggle="tab">'.$language->name.'</a>
                      </li>';

            $panels .= '<div role="tabpanel" class="tab-pane '.($firstTab ? 'active' : '').'" id="'.$language->name.'">';
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

            $firstTab = false;
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
    public function fields()
    {
        return $this->fields;
    }

    /**
     * Get a field definition.
     *
     * @param $field
     *
     * @throws InvalidField
     *
     * @return AbstractType
     */
    public function get($field)
    {
        if (array_key_exists($field, $this->fields)) {
            return $this->fields[$field];
        }

        throw new InvalidField("The requested field index [{$field}] has not been defined.");
    }

    /**
     * Set a dataSource when you want the form
     * to be prefilled with values.
     *
     * @param array|Model|Translatable $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Get value for a field, if it exists.
     *
     * @param $field
     * @param int $language_id
     *
     * @return mixed|null
     */
    public function getValue($field, $language_id = 0)
    {
        $dataSource = $this->dataSource;

        if ($dataSource instanceof Translatable && $language_id > 0) {
            $dataSource = array_merge(
                $dataSource->toArray(),
                $dataSource->translate($language_id)->toArray()
            );
        }

        if ($dataSource instanceof Model) {
            $dataSource = $dataSource->toArray();
        }

        if (is_array($dataSource)) {
            $val = array_get($dataSource, $field);

            if (is_string($val)) {
                return htmlentities($val);
            }

            return $val;
        }
    }

    /**
     * Determine the value of a field if a data source
     * is set and add it to the field itself.
     *
     * @param $field
     */
    protected function setValue(AbstractType $field)
    {
        if(!$this->dataSource) {
            return;
        }

        $value = $this->getValue($field->getName());

        if ($field instanceof Image) {
            $src = $this->dataSource instanceof ImageFieldSource
                ? $this->dataSource->getImagePath() : '';
            $field->setSrc($src);
        }

        $field->setValue($value);
        $field->appendOption('value', $value);
    }

    /**
     * Skip given fields from rendering.
     *
     * @return $this
     */
    public function skip()
    {
        $fields = func_get_args();

        if (is_array($fields)) {
            $fields = array_flatten($fields);
        }

        if (count($fields) == 1 && is_string($fields[0])) {
            $fields = (array) $fields[0];
        }

        $this->skips = $fields;

        return $this;
    }

    /**
     * Get a field as a property.
     *
     * @param $name
     *
     * @throws InvalidField
     *
     * @return AbstractType
     */
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
