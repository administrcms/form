<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\CheckboxGroup;

class CheckboxGroupFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new CheckboxGroup('test', 'Test');

        $this->assertSame('administr/form::checkboxgroup', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
    
    /** @test */
    public function it_allows_definition_of_checkboxes()
    {
        $field = new CheckboxGroup('test', 'Test', function(CheckboxGroup $group) {
            $group
                ->checkbox('check1', ['value' => 1])
                ->checkbox('check2', ['value' => 2])
                ;
        });

        $this->assertCount(2, $field->checkboxes());
    }

    /** @test */
    public function it_sets_value_to_checkboxes()
    {
        $field = new CheckboxGroup('test', 'Test', function(CheckboxGroup $group) {
            $group
                ->checkbox('check1', ['value' => 1])
            ;
        });

        $oldValue = $field->checkboxes()[0]->getValue();

        $field->setValue(2);

        $this->assertNotSame($oldValue, $field->checkboxes()[0]->getValue());
    }
}
