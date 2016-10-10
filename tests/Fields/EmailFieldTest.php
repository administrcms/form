<?php

namespace Administr\Form\Field;

class EmailFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Email('test', 'Test');

        $this->assertSame('email', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
