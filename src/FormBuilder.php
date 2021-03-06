<?php

namespace Administr\Form;

use Administr\Form\Contracts\ImageFieldSource;
use Administr\Form\Exceptions\InvalidField;
use Administr\Form\Field\Field;
use Administr\Form\Field\Group;
use Administr\Form\Field\Image;
use Administr\Form\Field\Text;
use Administr\Form\Field\Translated;
use Administr\Localization\Models\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
 * @method FormBuilder translated(Closure $definition)
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
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Add a field to the form.
     *
     * @param Field $field
     *
     * @return $this
     */
    public function add(Field $field)
    {
        if($this->hasRules($field->getName())) {
            $field->setOption('data-validation', json_encode($this->getRules($field->getName())));
        }

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

        $fields = array_filter($this->fields, function (Field $field) {
            return !in_array($field->getName(), $this->skips) && !$field->isSkipped();
        });

        foreach ($fields as $name => $field) {
            $form .= $this->renderField($name, [], $viewData);
        }

        return $form;
    }

    public function renderField($name, array $attributes = [], array $viewData = [])
    {
        $field = $this->get($name);
        $this->setValue($field);

        if($field instanceof Group || $field instanceof Translated) {
            $field->builder()->dataSource($this->dataSource);
        }

        return $field->render($attributes, $viewData);
    }

    /**
     * Get fields of given type.
     *
     * @param $type
     * @return array
     */
    public function fieldsOfType($type = Field::class)
    {
        return collect($this->fields())
            ->filter(function(Field $field) use($type) {
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
     * @return Field
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
     * @param null $dataSource
     * @return FormBuilder
     */
    public function dataSource($dataSource = null)
    {
        if(is_null($dataSource)) {
            return $this->dataSource;
        }

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
            $val = Arr::get($dataSource, $field);

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
    protected function setValue(Field $field)
    {
        if(!$this->dataSource) {
            return;
        }

        $value = $this->getValue($field->getEscapedName());

        if ($field instanceof Image) {
            $src = $this->dataSource instanceof ImageFieldSource
                ? $this->dataSource->getImagePath($field->getName()) : '';
            $field->setSrc($src);
        }

        $field->setValue($value);
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
            $fields = Arr::flatten($fields);
        }

        if (count($fields) == 1 && is_string($fields[0])) {
            $fields = (array) $fields[0];
        }

        $this->skips = $fields;

        return $this;
    }

    /**
     * Set validation rules.
     *
     * @param array $parsedRules
     * @return $this
     */
    public function setValidationRules($parsedRules)
    {
        $this->rules = $parsedRules;
        return $this;
    }

    /**
     * Verify if a validation rule for a field exists.
     *
     * @param $field
     * @return bool
     */
    public function hasRules($field)
    {
        return Arr::has($this->rules, $field);
    }

    /**
     * Get the validation rules for a field.
     *
     * @param string $field
     * @param array $default
     * @return array
     */
    public function getRules($field = null, $default = [])
    {
        if(is_null($field)) {
            return $this->rules;
        }

        return Arr::get($this->rules, $field, $default);
    }

    /**
     * Get a field as a property.
     *
     * @param $name
     *
     * @throws InvalidField
     *
     * @return Field
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
        $class = 'Administr\\Form\\Field\\' . Str::studly($name);

        if (!class_exists($class)) {
            $class = Text::class;
        }

        $reflector = new \ReflectionClass($class);

        $this->add($reflector->newInstanceArgs($args));

        return $this;
    }
}
