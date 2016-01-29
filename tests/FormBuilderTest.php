<?php

use Administr\Form\Field\Text;
use Administr\Form\FormBuilder;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_zero_fields_after_init()
    {
        $formBuilder = new FormBuilder;

        $this->assertCount(0, $formBuilder->getFields());
    }

    /**
     * @test
     */
    public function it_adds_a_field_to_the_fields_array()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->add(new Text('test', 'Test'));

        $this->assertCount(1, $formBuilder->getFields());
    }

    /**
     * @test
     */
    public function it_returns_the_form_builder_object_after_add()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->add(new Text('test', 'Test'));

        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /**
     * @test
     */
    public function it_adds_a_text_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->text('test', 'Test');

        $field = $formBuilder->getFields()[0];

        $this->assertInstanceOf(Text::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /**
     * @test
     */
    public function it_returns_an_array_of_the_form_fields()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->text('test', 'Test');

        $this->assertCount(1, $formBuilder->getFields());
        $this->assertInternalType('array', $formBuilder->getFields());
    }
}