<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Search;

class SearchFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Search('test', 'Test');

        $this->assertSame('search', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
