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

    /** @test */
    public function it_marks_the_checked_option()
    {
        $field = new Select('test', 'Test', [
            'values'    => [
                'foo'   => 'Foo',
                'bar'   => 'Bar',
            ]
        ]);

        $field->render(['value' => 'foo']);

        $optionFields = $field->options();

        $this->assertSame('selected', $optionFields[0]->getOption('selected'));
    }

    /** @test */
    public function it_does_not_mark_the_checked_option_when_values_are_missing()
    {
        $field = new Select('test', 'Test', []);

        $field->render(['value' => 'foo']);

        $optionFields = $field->options();

        $this->assertCount(0, $optionFields);
    }
}
