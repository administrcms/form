<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Submit;

class SubmitFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Submit('test', 'Test');

        $this->assertSame('submit', $field->getOption('type'));
        $this->assertSame('administr::form.submit', $field->getView());
        $this->assertSame('Test', $field->getValue());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
