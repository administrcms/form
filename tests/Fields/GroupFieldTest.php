<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Group;
use Administr\Form\Field\Text;
use Administr\Form\FormBuilder;

class GroupFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Group('test', 'Test', function(FormBuilder $builder) {
        });

        $this->assertSame('administr/form::group', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
    
    /** @test */
    public function it_returns_the_builder_instance()
    {
        $field = new Group('test', 'Test', function(FormBuilder $builder) {
        });

        $this->assertInstanceOf(FormBuilder::class, $field->builder());
    }

    /** @test */
    public function it_returns_a_field_from_the_builder()
    {
        $field = new Group('test', 'Test', function(FormBuilder $builder) {
            $builder
                ->text('foo', 'Bar')
                ;
        });

        $this->assertInstanceOf(Text::class, $field->get('foo'));
    }
}
