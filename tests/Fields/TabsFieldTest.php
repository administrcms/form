<?php

namespace Administr\Form\Field;

use Administr\Form\FormBuilder;

class TabsFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Tabs('test', ['tab 1', 'tab 2']);

        $this->assertSame('administr/form::tabs', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
    
    /** @test */
    public function it_returns_all_tab_builders_when_tab_is_not_specified()
    {
        $field = new Tabs('test', ['tab 1', 'tab 2']);

        $this->assertCount(2, $field->builder());
    }

    /** @test */
    public function it_returns_a_single_builder_for_a_tab()
    {
        $field = new Tabs('test', [1 => 'tab 1', 2 => 'tab 2']);

        $this->assertInstanceOf(FormBuilder::class, $field->builder(1));
    }

    /** @test */
    public function it_defines_a_field_in_a_builder()
    {
        $field = new Tabs('test', [1 => 'tab 1', 2 => 'tab 2']);

        $field->define(function(array $builders) {
                $builders[1]
                    ->text('textfield', 'Text Field')
                ;

                $builders[2]
                    ->email('textfield2', 'Text Field 2')
                ;
        });

        $this->assertInstanceOf(Text::class, $field->get(1, 'textfield'));
        $this->assertInstanceOf(Email::class, $field->get(2, 'textfield2'));
    }
}
