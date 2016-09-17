<?php

namespace Administr\Form\Field;

use Administr\Form\Presenters\BootstrapPresenter;

class BootstrapPresenterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_presents_a_text_field_correctly()
    {
        $text = new Text('test', 'Test');
        $presenter = new BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="text" id="test" name="test" class="form-control" value="">'."\n".
            '<span class="help-block"></span>'."\n".
            '</div>',

            $presenter->render($text)
        );
    }

    /** @test */
    public function it_presents_a_text_field_correctly_with_error()
    {
        $text = new Text('test', 'Test');
        $presenter = new BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group has-error">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="text" id="test" name="test" class="form-control" value="">'."\n".
            '<span class="help-block">miro</span>'."\n".
            '</div>',

            $presenter->render($text, ['miro'])
        );
    }

    /** @test */
    public function it_presents_a_button_field_correctly()
    {
        $submit = new Submit('test', 'Test');
        $presenter = new BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group">'."\n".
            '<input type="submit" id="test" name="test" value="Test" class="btn btn-primary">'."\n".
            '</div>',

            $presenter->render($submit)
        );
    }

    /** @test */
    public function it_presents_a_radio_field_correctly()
    {
        $radio = new Radio('test', 'Test', ['value' => 'test']);
        $presenter = new BootstrapPresenter();

        $this->assertSame(
            '<div class="radio">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="radio" id="test" name="test" value="test" class="">'."\n".
            '<span class="help-block"></span>'."\n".
            '</div>',

            $presenter->render($radio)
        );
    }

    /** @test */
    public function it_presents_a_checkbox_field_correctly()
    {
        $checkbox = new Checkbox('test', 'Test', ['value' => 1]);
        $presenter = new BootstrapPresenter();

        $this->assertSame(
            '<div class="checkbox">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="checkbox" id="test" name="test" value="1" class="" checked="checked">'."\n".
            '<span class="help-block"></span>'."\n".
            '</div>',

            $presenter->render($checkbox)
        );
    }
}

function old($field, $default = null)
{
    return $default;
}

function make($class)
{
}
