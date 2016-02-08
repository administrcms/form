<?php

class BootstrapPresenterTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_presents_a_text_field_correctly()
    {
        $text = new \Administr\Form\Field\Text('test', 'Test');
        $presenter = new \Administr\Form\Presenters\BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="text" id="test" name="test" value="" class="form-control">'."\n".
            '<span class="help-block"></span>'."\n".
            '</div>',

            $presenter->render($text)
        );
    }

    /** @test */
    public function it_presents_a_text_field_correctly_with_error()
    {
        $text = new \Administr\Form\Field\Text('test', 'Test');
        $presenter = new \Administr\Form\Presenters\BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group has-error">'."\n".
            '<label for="test">Test</label>'."\n".
            '<input type="text" id="test" name="test" value="" class="form-control">'."\n".
            '<span class="help-block">miro</span>'."\n".
            '</div>',

            $presenter->render($text, ['miro'])
        );
    }

    /** @test */
    public function it_presents_a_button_field_correctly()
    {
        $submit = new \Administr\Form\Field\Submit('test', 'Test');
        $presenter = new \Administr\Form\Presenters\BootstrapPresenter();

        $this->assertSame(
            '<div class="form-group">'."\n".
            '<input type="submit" id="test" name="test" value="Test" class="btn btn-primary">'."\n".
            '</div>',

            $presenter->render($submit)
        );
    }
}
