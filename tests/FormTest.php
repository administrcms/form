<?php

use Mockery as m;

use Administr\Form\Form;
use Administr\Form\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Illuminate\Routing\Redirector;

class FormTest extends PHPUnit_Framework_TestCase
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

        $form->expects($this->once())
            ->method('form');

        $reflectedClass = new ReflectionClass($form);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($form, new FormBuilder, $this->request, $this->validator, $this->redirector);
    }

    /** @test */
    public function it_renders_the_form()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->presenter = null;

        $form = new TestForm(
            $formBuilder,
            $this->request,
            $this->validator,
            $this->redirector
        );

        $this->request
            ->shouldReceive('session')
            ->once()
            ->andReturn(new SessionMock);

        $this->assertSame('<form>' . "\n" . '<label for="test">Test</label>' . "\n" . '<input type="text" id="test" name="test" value="">' . "\n" . '</form>' . "\n", $form->render());
    }

    /** @test */
    public function it_sets_form_option()
    {
        $formBuilder = new FormBuilder;
        $formBuilder->presenter = null;

        $form = new TestForm(
            $formBuilder,
            $this->request,
            $this->validator,
            $this->redirector
        );
        $form->method = 'post';

        $this->request
            ->shouldReceive('session')
            ->once()
            ->andReturn(new SessionMock);

        $this->assertSame('<form method="post">' . "\n" . '<label for="test">Test</label>' . "\n" . '<input type="text" id="test" name="test" value="">' . "\n" . '</form>' . "\n", $form->render());
    }

    /** @test */
    public function it_gets_form_option()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator, $this->redirector);
        $form->method = 'post';

        $this->assertSame('post', $form->method);
    }

    /** @test */
    public function it_gets_null_for_nonexisting_form_option()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator, $this->redirector);

        $this->request
            ->shouldReceive('get')
            ->once()
            ->andReturn(null);

        $this->assertNull($form->method);
    }

    /** @test */
    public function it_validates_when_no_rules_are_added()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator, $this->redirector);

        $this->assertTrue($form->isValid());
    }

    /** @test */
    public function it_does_not_validate()
    {
        $form = new TestWithRulesForm(new FormBuilder, $this->request, $this->validator, $this->redirector);

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
     * Define the fields of the form
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
     * Define the fields of the form
     *
     * @param FormBuilder $form
     */
    public function form(FormBuilder $form)
    {
        $form->text('test', 'Test');
    }
}

class SessionMock {
    public function get()
    {
        return null;
    }
}