<?php

namespace Administr\Form\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeFormCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'administr:form {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a form class.';

    protected $type = 'Form class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/form.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Forms';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the form class.'],
        ];
    }
}
