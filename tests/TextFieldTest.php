<?php

namespace Administr\Form\Field;

class TextFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('administr::form.text', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
