<?php

namespace Administr\Form;

use Administr\Form\Contracts\ImageFieldSource;
use Administr\Form\Exceptions\InvalidField;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Group;
use Administr\Form\Field\Image;
use Administr\Form\Field\RadioGroup;
use Administr\Form\Field\Text;
use Administr\Localization\Models\Language;
use Administr\Localization\Models\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormBuilder.
 *
 * @method FormBuilder text($name, $label, array $options = [])
 * @method FormBuilder password($name, $label, array $options = [])
 * @method FormBuilder textarea($name, $label, array $options = [])
 * @method FormBuilder email($name, $label, array $options = [])
 * @method FormBuilder file($name, $label, array $options = [])
 * @method FormBuilder image($name, $label, array $options = [])
 * @method FormBuilder hidden($name, $value, array $options = [])
 * @method FormBuilder checkbox($name, $label, array $options = [])
 * @method FormBuilder radio($name, $label, array $options = [])
 * @method FormBuilder select($name, $label, array $options = [])
 * @method FormBuilder wysiwyg($name, $label, array $options = [])
 * @method FormBuilder submit($name, $label, array $options = [])
 * @method FormBuilder reset($name, $label, array $options = [])
 * @method FormBuilder group($name, $label, Closure $definition)
 * @method FormBuilder radioGroup($name, $label, Closure $definition)
 * @method FormBuilder checkboxGroup($name, $label, Closure $definition)
 * @method FormBuilder color($name, $label, array $options = [])
 * @method FormBuilder date($name, $label, array $options = [])
 * @method FormBuilder datetime($name, $label, array $options = [])
 * @method FormBuilder time($name, $label, array $options = [])
 * @method FormBuilder week($name, $label, array $options = [])
 * @method FormBuilder month($name, $label, array $options = [])
 * @method FormBuilder number($name, $label, array $options = [])
 * @method FormBuilder range($name, $label, array $options = [])
 * @method FormBuilder search($name, $label, array $options = [])
 * @method FormBuilder tel($name, $label, array $options = [])
 * @method FormBuilder url($name, $label, array $options = [])
 * @method FormBuilder tabs($name, $label, Closure $definition)
 *
 */
class FormBuilder
{
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
     * Render form fields.
     *
     * @param array $viewData
     *
     * @return string
     */
    public function render(array $viewData = [])
    {
        $form = '';

        $fields = array_filter($this->fields, function (AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && !$field->isSkipped() && !$field->isTranslated();
        });

        $fieldsCount = count($fields);
        $renderedFieldsCount = 1;

        foreach ($fields as $name => $field) {
            $this->setValue($field);

            if ($field->isButton() || $fieldsCount === $renderedFieldsCount && !$this->translationRendered) {
                $form .= $this->renderTranslated($viewData);
            }

            $form .= $this->renderField($name, [], $viewData);

            $renderedFieldsCount += 1;
        }

        return $form;
    }

    public function renderField($name, array $attributes = [], array $viewData = [])
    {
        $field = $this->get($name);
        $this->setValue($field);

        if($field instanceof Group) {
            $field->builder()->dataSource($this->dataSource);
        }

        return $field->render($attributes, $viewData);
    }

    /**
     * Render a tabs container with available languages
     * and the fields that contain translatable data.
     *
     * @return string
     */
    public function renderTranslated(array $viewData = [])
    {
        $this->translationRendered = true;

        $firstTab = true;
        $tabs = '';
        $panels = '';
        $fields = array_filter($this->fields, function (AbstractType $field) {
            return !in_array($field->getName(), $this->skips) && !$field->isSkipped() && $field->isTranslated();
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
                    $field->setValue($value);
                }

                $panels .= $field->render($viewData);
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
     * Get fields of given type.
     *
     * @param $type
     * @return array
     */
    public function fieldsOfType($type = AbstractType::class)
    {
        return collect($this->fields())
            ->filter(function(AbstractType $field) use($type) {
                return $field instanceof $type;
            })
            ->toArray();
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
     * to be prefilled with values. If empty value passed,
     * get the currently set dataSource.
     *
     * @param array|Model|Translatable $dataSource
     * @return FormBuilder
     * @deprecated
     */
    public function setDataSource($dataSource)
    {
        return $this->dataSource($dataSource);
    }

    /**
     * Set a dataSource when you want the form
     * to be prefilled with values.
     *
     * @param null $dataSource
     * @return FormBuilder
     */
    public function dataSource($dataSource)
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    public function hasDataSource()
    {
        return !is_null($this->dataSource);
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
                ? $this->dataSource->getImagePath($field->getName()) : '';
            $field->setSrc($src);
        }

        if(is_null($value)) {
            return;
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
