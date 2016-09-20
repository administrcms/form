<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;

class CheckboxFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Checkbox('test', 'Test');

        $this->assertSame('administr::form.checkbox', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
