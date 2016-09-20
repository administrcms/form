<?php

namespace Administr\Form\Field;

class ResetFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Reset('test', 'Test');

        $this->assertSame('reset', $field->getOption('type'));
        $this->assertSame('administr::form.submit', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
