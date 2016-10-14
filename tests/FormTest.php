<?php

namespace Administr\Form;

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Hidden;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Factory;
use Mockery as m;
use ReflectionClass;

class FormTest extends \PHPUnit_Framework_TestCase
{
    private $request;
    private $validator;
    private $redirector;

    public function setUp()
    {
        $this->request = m::mock(Request::class);
        $this->validator = m::mock(Factory::class);
        $this->redirector = m::mock(Redirector::class);
    }

    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_calls_the_form_method_after_construction()
    {
        $form = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->setMethods(['form'])
            ->getMockForAbstractClass();

//        $form->expects($this->once())
//            ->method('form');

        $reflectedClass = new ReflectionClass($form);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($form, new FormBuilder(), $this->request, $this->validator, $this->redirector);
    }

//    /** @test */
//    public function it_renders_the_form()
//    {
//        $formBuilder = new FormBuilder();
//        $formBuilder->presenter = null;
//
//        $form = new TestForm(
//            $formBuilder,
//            $this->request,
//            $this->validator,
//            $this->redirector
//        );
//
//        $this->request
//            ->shouldReceive('session')
//            ->once()
//            ->andReturn(new SessionMock());
//
//        $this->assertSame('<form enctype="application/x-www-form-urlencoded">'."\n".'<label for="test">Test</label>'."\n".'<input type="text" id="test" name="test" value="">'."\n".'<input type="hidden" id="_token" name="_token" value="">'."\n".'<input type="hidden" id="_method" name="_method" value="">'."\n".'</form>'."\n", $form->render());
//    }

    /** @test */
    public function it_sets_and_gets_form_option()
    {
        $form = new TestForm(new FormBuilder(), $this->request, $this->validator, $this->redirector);
        $form->method = 'post';

        $this->assertSame('post', $form->method);
    }

    /** @test */
    public function it_gets_null_for_nonexisting_form_option()
    {
        $form = new TestForm(new FormBuilder(), $this->request, $this->validator, $this->redirector);

        $this->request
            ->shouldReceive('get')
            ->once()
            ->andReturn(null);

        $this->assertNull($form->method);
    }

    /** @test */
    public function it_validates_when_no_rules_are_added()
    {
        $form = new TestForm(new FormBuilder(), $this->request, $this->validator, $this->redirector);

        $this->assertTrue($form->isValid());
    }

    /** @test */
    public function it_does_not_validate()
    {
        $form = new TestWithRulesForm(new FormBuilder(), $this->request, $this->validator, $this->redirector);

        $this->request
            ->shouldReceive('all')
            ->once()
            ->andReturn(['email' => '']);

        $this->validator
            ->shouldReceive('make')
            ->once()
            ->andReturn($this->validator);

        $this->validator
            ->shouldReceive('passes')
            ->once()
            ->andReturn(false);

        $this->assertFalse($form->isValid());
    }

    /** @test */
    public function it_gets_a_field_from_the_form_builder()
    {
        $formBuilder = new FormBuilder();
        $form = new TestForm($formBuilder, $this->request, $this->validator, $this->redirector);

        $form->open();

        $this->assertInstanceOf(AbstractType::class, $form->field('test'));
    }

    /** @test */
    public function it_gets_an_array_of_the_fields_in_the_form_builder()
    {
        $form = new TestForm(new FormBuilder(), $this->request, $this->validator, $this->redirector);

        $form->open();

        $this->assertCount(3, $form->fields());
    }

//    /** @test */
//    public function it_converts_the_form_to_string()
//    {
//        $formBuilder = new FormBuilder();
//        $formBuilder->presenter = null;
//
//        $form = new TestForm($formBuilder, $this->request, $this->validator, $this->redirector);
//
//        $this->request
//            ->shouldReceive('session')
//            ->once()
//            ->andReturn(new SessionMock());
//
//        $this->assertSame('<form enctype="application/x-www-form-urlencoded">'."\n".'<label for="test">Test</label>'."\n".'<input type="text" id="test" name="test" value="">'."\n".'<input type="hidden" id="_token" name="_token" value="">'."\n".'<input type="hidden" id="_method" name="_method" value="">'."\n".'</form>'."\n", (string) $form);
//    }

    /** @test */
    public function it_simulates_a_put_method()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->presenter = null;

        $form = new TestForm($formBuilder, $this->request, $this->validator, $this->redirector);

        $form->method = 'put';
        $form->open();
        $fields = $form->fields();

        $this->assertSame('post', $form->method);
        $this->assertInstanceOf(Hidden::class, end($fields));
    }

    /** @test */
    public function it_sets_correct_enctype_for_form_uploads()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->presenter = null;

        $formBuilder->file('file', 'File');

        $form = new TestForm(
            $formBuilder,
            $this->request,
            $this->validator,
            $this->redirector
        );

        $form->open();

        $this->assertContains('multipart/form-data', $form->enctype);
    }

    /** @test */
    public function it_adds_csrf_field()
    {
        $formBuilder = new FormBuilder();
        $formBuilder->presenter = null;

        $form = new TestForm(
            $formBuilder,
            $this->request,
            $this->validator,
            $this->redirector
        );

        $form->open();

        $this->assertTrue(
            array_key_exists('_token', $form->fields())
        );
        $this->assertInstanceOf(Hidden::class, $form->field('_token'));
    }
}

class TestForm extends Form
{
    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Define the fields of the form.
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form->text('test', 'Test');
    }
}

class TestWithRulesForm extends Form
{
    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test'  => 'required',
        ];
    }

    /**
     * Define the fields of the form.
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form->text('test', 'Test');
    }
}

function view($name, $data)
{

}

class SessionMock
{
    public function get()
    {
    }
}

function csrf_token()
{
    return null;
}