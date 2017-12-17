<?php

namespace Administr\Form\Field;

use Administr\Form\FormBuilder;

class Tabs extends Field
{
    protected $tabs = [];
    protected $contents = [];

    /**
     * @var array
     */
    protected $builders;

    public function __construct($name, array $tabs, \Closure $definition = null)
    {
        parent::__construct($name, '', []);

        $this->tabs = $tabs;

        foreach(array_keys($tabs) as $key) {
            $this->contents[$key] = new FormBuilder();
        }

        if(!is_null($definition)) {
            $this->define($definition);
        }
    }

    public function define(\Closure $definition)
    {
        call_user_func($definition, $this->contents);

        return $this;
    }

    /**
     * @param array $attributes
     * @param array $viewData
     * @return string
     * @codeCoverageIngore
     */
    public function render(array $attributes = [], array $viewData = [])
    {
        $viewData['tabs'] = $this->tabs;
        $viewData['contents'] = $this->contents;

        return parent::render($attributes, $viewData);
    }

    /**
     * @param int $tab Tab index
     * @return FormBuilder|array
     */
    public function builder($tab = null)
    {
        if(! array_has($this->contents, $tab)) {
            return $this->contents;
        }

        return $this->contents[$tab];
    }

    /**
     * @param $tab
     * @param $field
     * @return Field
     */
    public function get($tab, $field)
    {
        return $this->builder($tab)->get($field);
    }
}