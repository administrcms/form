<?php

use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Email;
use Administr\Form\Field\Option;
use Administr\Form\Field\Password;
use Administr\Form\Field\Radio;
use Administr\Form\Field\Select;
use Administr\Form\Field\Text;
use Administr\Form\Field\Textarea;
use Administr\Form\FormBuilder;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_has_zero_fields_after_init()
    {
        $formBuilder = new FormBuilder;

        $this->assertCount(0, $formBuilder->getFields());
    }


    /** @test */
    public function it_adds_a_field_to_the_fields_array()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->add(new Text('test', 'Test'));

        $this->assertCount(1, $formBuilder->getFields());
    }


    /** @test */
    public function it_returns_the_form_builder_object_after_add()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->add(new Text('test', 'Test'));

        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_text_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->text('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Text::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_textarea_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->textarea('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Textarea::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_radio_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->radio('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Radio::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_checkbox_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->checkbox('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Checkbox::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_select_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->select('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Select::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_select_with_options_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->select('test', 'Test', [
            'value' => ['test' => 'Test']
        ]);

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Select::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_an_option_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->option('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Option::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_an_email_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->email('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Email::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_password_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder;
        $builder = $formBuilder->password('test', 'Test');

        $field = $formBuilder->getFields()['test'];

        $this->assertInstanceOf(Password::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_returns_an_array_of_the_form_fields()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->text('test', 'Test');

        $this->assertCount(1, $formBuilder->getFields());
        $this->assertInternalType('array', $formBuilder->getFields());
    }
    
    /** @test */
    public function it_renders_a_basic_form()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->text('test', 'Test');

        $this->assertSame('<label for="test">Test</label><input type="text" id="test" name="test">', $formBuilder->render());
    }
    
    /** @test */
    public function it_gets_a_field()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->text('test', 'Test');

        $this->assertInstanceOf(Text::class, $formBuilder->get('test'));
    }

    /** @test */
    public function it_gets_a_field_with_magic_function()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->text('test', 'Test');

        $this->assertInstanceOf(Text::class, $formBuilder->test);
    }

    /**
     * @test
     * @expectedException \Administr\Form\Exceptions\InvalidField
     */
    public function it_throws_an_exeption_when_invalid_field_is_requested()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->test;
    }
}