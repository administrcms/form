<?php

namespace Administr\Form\Field;

class SelectFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Select('test', 'Test');

        $this->assertSame('administr/form::select', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }

    /** @test */
    public function it_renders_with_options_the_full_html()
    {
        $field = new Select('test', 'Test', [
            'values' => ['miro' => 'test'],
        ]);

        $field->render();

        $options = $field->options();
        $this->assertCount(1, $options);
        $this->assertInstanceOf(Option::class, $options[0]);
    }

//    /** @test */
//    public function it_marks_the_checked_option()
//    {
//        $field = new Select('test', 'Test', [
//            'values' => [
//                'miro' => 'test',
//                'test' => 'miro',
//            ],
//            'value' => 'miro',
//        ]);
//
//        $field->render();
//
//        $optionFields = $field->options();
//
//        $this->assertSame('selected', $optionFields[0]->getOption('selected'));
//    }
}
