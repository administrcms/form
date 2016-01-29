<?php

use Administr\Form\Form;
use Administr\Form\FormBuilder;

class FormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
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
}