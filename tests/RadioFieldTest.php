<?php

namespace Administr\Form\Field;

class RadioFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Radio('test', 'Test', ['value' => 'test']);

        $this->assertSame('administr.form::radio', $field->getView());
        $this->assertInstanceOf(Text::class, $field);
    }

    /** @test */
    public function it_sets_checked_state()
    {
        $field = (new Radio('test', 'Test'))
            ->appendOption('value', 'should_be_checked')
            ->setValue('should_be_checked');

        $field->render();

        $this->assertSame('checked', $field->getOption('checked'));
    }
}

