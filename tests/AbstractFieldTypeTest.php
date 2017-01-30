<?php

namespace Administr\Form\Field;

class AbstractFieldTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_allows_for_view_override()
    {
        $field = (new Text('test', 'Test'))->setView('new.view');

        $this->assertSame('new.view', $field->getView());
    }

    /** @test */
    public function it_returns_an_empty_string_for_no_args()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('', $field->renderAttributes());
    }

    /** @test */
    public function it_returns_correct_string_for_args()
    {
        $field = new Text('test', 'Test', ['test' => 'miro']);

        $this->assertSame(' test="miro"', $field->attributes());
    }

    /** @test */
    public function it_returns_correct_string_for_args_when_array_given()
    {
        $field = new Text('test', 'Test', ['test' => 'miro', 'array' => ['multi' => 'value']]);

        $this->assertSame(' test="miro"', $field->attributes());
    }

    /** @test */
    public function it_gets_field_name()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('test', $field->getName());
    }
    
    /** @test */
    public function it_sets_field_name()
    {
        $field = new Text('test', 'Test');
        $field->setName('named');

        $this->assertSame('named', $field->getName());
    }

    /** @test */
    public function it_gets_field_label()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('Test', $field->getLabel());
    }

    /** @test */
    public function it_sets_field_label()
    {
        $field = new Text('test', 'Test');
        $field->setLabel('labeled');

        $this->assertSame('labeled', $field->getLabel());
    }

    /** @test */
    public function it_gets_field_options()
    {
        $field = new Text('test', 'Test');

        $this->assertSame([], $field->getOptions());
    }

    /** @test */
    public function it_appends_an_option()
    {
        $field = (new Text('test', 'Test'))->appendOption('new', 'option');

        $this->assertSame(['new' => 'option'], $field->getOptions());
    }
    
    /** @test */
    public function it_sets_translatable_option()
    {
        $field = (new Text('test', 'Test'))->translated();

        $this->assertContains('translated', $field->getOptions());
        $this->assertTrue($field->isTranslated());
    }

    /** @test */
    public function it_is_skippable()
    {
        $field = new Text('test', 'Test');
        $field->skipIf(true);

        $this->assertTrue($field->isSkipped());
    }

    /** @test */
    public function it_doesnt_set_skip_option_if_it_is_not_boolean()
    {
        $field = new Text('test', 'Test');
        $field->skipIf('asd');

        $this->assertFalse($field->isSkipped());
    }

    /** @test */
    public function it_is_not_skippable_by_default()
    {
        $field = new Text('test', 'Test');

        $this->assertFalse($field->isSkipped());
    }

    /** @test */
    public function it_calls_methods_when_option_name_is_the_same()
    {
        $field = new Text('test', 'Test', ['skipIf' => true]);

        $this->assertTrue($field->isSkipped());
    }

    /** @test */
    public function it_sets_multiple_options_after_instantiation()
    {
        $field = new Text('test', 'Test');

        $this->assertCount(0, $field->getOptions());

        $field->setOptions(['skipIf' => true]);

        $this->assertCount(1, $field->getOptions());
    }

    /** @test */
    public function it_sets_single_option_after_instantiation()
    {
        $field = new Text('test', 'Test');

        $this->assertNull($field->getOption('miro'));

        $field->setOption('miro', 'vit');

        $this->assertSame('vit', $field->getOption('miro'));
    }

    /** @test */
    public function it_appends_multiple_options_after_instantiation()
    {
        $field = new Text('test', 'Test', ['miro' => 'vit']);

        $this->assertCount(1, $field->getOptions());

        $field->appendOptions(['option1' => 1, 'option2' => 2]);

        $this->assertCount(3, $field->getOptions());
    }

    /** @test */
    public function it_appends_single_option_after_instantiation()
    {
        $field = new Text('test', 'Test', ['miro' => 'vit']);

        $this->assertNull($field->getOption('present'));

        $field->appendOption('present', true);

        $this->assertTrue($field->getOption('present'));
    }
}

function make()
{
    return;
}

function old($name, $default)
{
    return $default;
}

function view($name, $data)
{
    return;
}

function request($name)
{
    return $name;
}

function session()
{
    return;
}