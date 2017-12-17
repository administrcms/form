<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Url;

class UrlFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Url('test', 'Test');

        $this->assertSame('url', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
