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
        $field = new Text('test', 'Test');

        $this->assertSame(' test="miro"', $field->renderAttributes(['test' => 'miro']));
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