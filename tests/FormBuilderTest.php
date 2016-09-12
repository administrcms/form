<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Checkbox;
use Administr\Form\Field\Email;
use Administr\Form\Field\Hidden;
use Administr\Form\Field\Option;
use Administr\Form\Field\Password;
use Administr\Form\Field\Radio;
use Administr\Form\Field\RadioGroup;
use Administr\Form\Field\Select;
use Administr\Form\Field\Submit;
use Administr\Form\Field\Text;
use Administr\Form\Field\Textarea;
use Administr\Form\FormBuilder;
use Administr\Form\Presenters\Presenter;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_has_zero_fields_after_init()
    {
        $formBuilder = new FormBuilder();

        $this->assertCount(0, $formBuilder->fields());
    }

    /** @test */
    public function it_adds_a_field_to_the_fields_array()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->add(new Text('test', 'Test'));

        $this->assertCount(1, $formBuilder->fields());
    }

    /** @test */
    public function it_returns_the_form_builder_object_after_add()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->add(new Text('test', 'Test'));

        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_text_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->text('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Text::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_textarea_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->textarea('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Textarea::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_radio_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->radio('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Radio::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_checkbox_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->checkbox('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Checkbox::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_select_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->select('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Select::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_select_with_options_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->select('test', 'Test', [
            'value' => ['test' => 'Test'],
        ]);

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Select::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_an_option_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->option('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Option::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_an_email_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->email('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Email::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_password_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->password('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Password::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_submit_button_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->submit('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Submit::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_adds_a_hidden_field_and_returns_form_builder_object()
    {
        $formBuilder = new FormBuilder();
        $builder = $formBuilder->hidden('test', 'Test');

        $field = $formBuilder->fields()['test'];

        $this->assertInstanceOf(Hidden::class, $field);
        $this->assertInstanceOf(FormBuilder::class, $builder);
    }

    /** @test */
    public function it_returns_an_array_of_the_form_fields()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test');

        $this->assertCount(1, $formBuilder->fields());
        $this->assertInternalType('array', $formBuilder->fields());
    }

    /** @test */
    public function it_renders_a_basic_form()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->presenter = null;
        $formBuilder->text('test', 'Test');

        $this->assertSame('<label for="test">Test</label>'."\n".'<input type="text" id="test" name="test" value="">'."\n", $formBuilder->render());
    }

    /** @test */
    public function it_gets_a_field()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test');

        $this->assertInstanceOf(Text::class, $formBuilder->get('test'));
    }

    /** @test */
    public function it_gets_a_field_with_magic_function()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test');

        $this->assertInstanceOf(Text::class, $formBuilder->test);
    }

    /**
     * @test
     * @expectedException \Administr\Form\Exceptions\InvalidField
     */
    public function it_throws_an_exeption_when_invalid_field_is_requested()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->test;
    }

    /** @test */
    public function it_uses_a_presenter_when_given()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->presenter = TestPresenter::class;
        $formBuilder->text('test', 'Test present');

        $this->assertNull($formBuilder->present($formBuilder->get('test')));
    }

    /** @test */
    public function it_falls_back_to_text_field_when_a_non_existing_type_is_requested()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->qwerty('test', 'Test present');

        $this->assertInstanceOf(Text::class, $formBuilder->test);
    }

    /** @test */
    public function it_appends_the_value_when_present()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test present', ['value' => 'testing']);

        $this->assertSame(['value' => 'testing'], $formBuilder->get('test')->getOptions());
    }

    /** @test */
    public function it_skips_fields()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test');

        $formBuilder->skip('test');

        $this->assertEquals(null, $formBuilder->render());
    }

    /** @test */
    public function it_skips_fields_with_array()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->text('test', 'Test');

        $formBuilder->skip(['test']);

        $this->assertEquals(null, $formBuilder->render());
    }

    /** @test */
    public function it_creates_a_radio_group()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->radioGroup('is_visible', 'Visible?', function (RadioGroup $group) {
            $group
               ->radio('Yes', ['value' => 1])
               ->radio('No', ['value' => 0]);
        });

        $this->assertInstanceOf(RadioGroup::class, $formBuilder->get('is_visible'));
    }

    /** @test */
    public function it_sets_a_data_source()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->setDataSource(['name' => 'test']);

        $this->assertSame('test', $formBuilder->getValue('name'));
    }

    /** @test */
    public function it_checks_if_datasource_is_present()
    {
        $formBuilder = new FormBuilder();

        $this->assertFalse($formBuilder->hasDataSource());

        $formBuilder->setDataSource(['name' => 'test']);

        $this->assertTrue($formBuilder->hasDataSource());
    }
}

class TestPresenter implements Presenter
{
    public function render(AbstractType $field, array $error = [])
    {
    }
}
