<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Checkbox;

class CheckboxFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Checkbox('test', 'Test');

        $this->assertSame('administr/form::checkbox', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
//
//    /** @test */
//    public function it_sets_checked_state()
//    {
//        $field = (new Checkbox('test', 'Test'))
//            ->appendOption('value', 'should_be_checked')
//            ->setValue('should_be_checked');
//
//        $field->render();
//
//        $this->assertSame('checked', $field->getOption('checked'));
//    }
}
