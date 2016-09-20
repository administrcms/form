<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\File;

class FileFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new File('test', 'Test');

        $this->assertSame('file', $field->getOption('type'));
        $this->assertSame('administr::form.text', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
