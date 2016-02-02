<?php

use Mockery as m;

use Administr\Form\Form;
use Administr\Form\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

class FormTest extends PHPUnit_Framework_TestCase
{
    private $request;
    private $validator;

    public function setUp()
    {
        $this->request = m::mock(Request::class);
        $this->validator = m::mock(Factory::class);
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
        $constructor->invoke($form, new FormBuilder, $this->request, $this->validator);
    }

    /** @test */
    public function it_renders_the_form()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator);

        $this->assertSame('<form>' . "\n" . '<label for="test">Test</label>' . "\n" . '<input type="text" id="test" name="test">' . "\n" . '</form>' . "\n", $form->render());
    }

    /** @test */
    public function it_sets_form_option()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator);
        $form->method = 'post';

        $this->assertSame('<form method="post">' . "\n" . '<label for="test">Test</label>' . "\n" . '<input type="text" id="test" name="test">' . "\n" . '</form>' . "\n", $form->render());
    }

    /** @test */
    public function it_gets_form_option()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator);
        $form->method = 'post';

        $this->assertSame('post', $form->method);
    }

    /** @test */
    public function it_gets_null_for_nonexisting_form_option()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator);

        $this->assertNull($form->method);
    }

    /** @test */
    public function it_validates_when_no_rules_are_added()
    {
        $form = new TestForm(new FormBuilder, $this->request, $this->validator);

        $this->assertTrue($form->isValid());
    }

//    /** @test */
//    public function it_does_not_validate()
//    {
//        $stub = $this->getMock(Request::class, ['all']);
//
//        $stub->expects($this->once())
//            ->method('all')
//            ->willReturn(['email' => '']);
//
//        $form = new TestWithRulesForm(new FormBuilder, $stub);
//
//        $this->assertFalse($form->isValid());
//    }
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

//class TestWithRulesForm extends Form
//{
//
//    /**
//     * Define the validation rules for the form.
//     *
//     * @return array
//     */
//    public function rules()
//    {
//        return [
//            'test'  => 'required',
//        ];
//    }
//
//    /**
//     * Define the fields of the form
//     *
//     * @param FormBuilder $form
//     */
//    public function form(FormBuilder $form)
//    {
//        $form->text('test', 'Test');
//    }
//}