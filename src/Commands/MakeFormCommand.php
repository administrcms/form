<?php

namespace Administr\Form\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @codeCoverageIgnore
 */
class MakeFormCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'administr:form';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a form class.';

    protected $type = 'Form class';

    public function fire()
    {
        parent::fire();

        $name = str_plural(
            str_replace( '-form', '', snake_case($this->argument('name'), '-') )
        );

        $from = __DIR__ . '/stubs/form.blade.stub';

        $viewPath = config('administr.viewPath');

        if(strlen($viewPath) > 0) {
            $viewPath .= '/';
        }

        $targetPath = resource_path("views/{$viewPath}{$name}/")
        $fileName = 'form.blade.php';

        if( $this->files->exists($targetPath . $fileName) )
        {
            $this->error("File views/{$name}/{$fileName} already exists!");
            return;
        }

        if( !$this->files->isDirectory($targetPath) )
        {
            $this->files->makeDirectory($targetPath);
        }

        if( $this->files->copy($from, $targetPath . $fileName) )
        {
            $this->info("Created views/{$name}/{$fileName}");
            return;
        }

        $this->error("Could not create views/{$name}/{$fileName}");
    }

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
     * @param string $rootNamespace
     *
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
