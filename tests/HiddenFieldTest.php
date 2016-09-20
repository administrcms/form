<?php

namespace Administr\Form\Field;

class HiddenFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Hidden('test', 'Test');

        $this->assertSame('administr/form::hidden', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
    
    /** @test */
    public function it_passses_the_label_as_value()
    {
        $field = new Hidden('test', 'Test');
        $field->render();

        $this->assertSame('Test', $field->getValue());
    }
}