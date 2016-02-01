<?php

use Administr\Form\Form;
use Administr\Form\FormBuilder;

class FormTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_calls_the_form_method_after_construction()
    {
        $form = $this->getMockBuilder(Form::class)
                    ->disableOriginalConstructor()
                    ->setMethods(['form'])
                    ->getMockForAbstractClass();

        $form->expects($this->once())
            ->method('form');

        $reflectedClass = new ReflectionClass(Form::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($form, new FormBuilder);
    }

    /** @test */
    public function it_renders_the_form()
    {
        $form = new TestForm(new FormBuilder);

        $this->assertSame('<form><label for="test">Test</label><input type="text" id="test" name="test"></form>', $form->render());
    }
}

class TestForm extends Form
{

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Implement rules() method.
    }

    /**
     * Define the fields of the form
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form->text('test', 'Test');
    }
}