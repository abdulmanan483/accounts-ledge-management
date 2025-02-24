<?php
namespace App\Console\Commands;

use Exception;
use function Laravel\Prompts\select;
use Ibex\CrudGenerator\Commands\GeneratorCommand;
use Ibex\CrudGenerator\ModelGenerator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CrudGenerator.
 *
 * @author  Awais <asargodha@gmail.com>
 */
class GenerateCrud extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud
                            {name : Table name}
                            {stack : The development stack that should be installed (bootstrap,tailwind,livewire,api)}
                            {--route= : Custom route name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Laravel CRUD operations';

    /**
     * Execute the console command.
     *
     * @throws FileNotFoundException
     */
    protected $namespaceFolder = '';
    public function handle()
    {
        $this->info('Running Crud Generator ...');


        $this->table = $this->getNameInput();

        // If table not exist in DB return
        if (! $this->tableExists()) {
            $this->error("`$this->table` table not exist");

            return false;
        }

        // Build the class name from table name
        $this->name = $this->_buildClassName();

        // Generate the crud
        $this->buildOptions()
            ->buildController()
            ->buildModel()
            ->buildViews()
            ->writeRoute();

        $this->info('Created Successfully.');

        return true;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'stack' => fn() => select(
                label: 'Which stack would you like to install?',
                options: [
                    'bootstrap' => 'Blade with Bootstrap css',
                    'tailwind'  => 'Blade with Tailwind css',
                    'livewire'  => 'Livewire with Tailwind css',
                    'api'       => 'API only',
                ],
                scroll: 4,
            ),
        ];
    }

    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output): void
    {
        $this->options['stack'] = match ($input->getArgument('stack')) {
            'tailwind' => 'tailwind',
            'livewire' => 'livewire',
            'react' => 'react',
            'vue' => 'vue',
            default => 'bootstrap',
        };
    }

    protected function writeRoute(): static
    {
        $replacements = $this->buildReplacements();

        $this->info('Please add route below: i:e; web.php or api.php');

        $this->info('');

        $lines = match ($this->options['stack']) {
            'livewire' => [
                "Route::get('/{$this->_getRoute()}', \\$this->livewireNamespace\\{$replacements['{{modelNamePluralUpperCase}}']}\Index::class)->name('{$this->_getRoute()}.index');",
                "Route::get('/{$this->_getRoute()}/create', \\$this->livewireNamespace\\{$replacements['{{modelNamePluralUpperCase}}']}\Create::class)->name('{$this->_getRoute()}.create');",
                "Route::get('/{$this->_getRoute()}/show/{{$replacements['{{modelNameLowerCase}}']}}', \\$this->livewireNamespace\\{$replacements['{{modelNamePluralUpperCase}}']}\Show::class)->name('{$this->_getRoute()}.show');",
                "Route::get('/{$this->_getRoute()}/update/{{$replacements['{{modelNameLowerCase}}']}}', \\$this->livewireNamespace\\{$replacements['{{modelNamePluralUpperCase}}']}\Edit::class)->name('{$this->_getRoute()}.edit');",
            ],
            'api' => [
                "Route::apiResource('" . $this->_getRoute() . "', {$this->name}Controller::class);",
            ],
            default => [
                "Route::resource('" . $this->_getRoute() . "', {$this->name}Controller::class);",
            ]
        };

        foreach ($lines as $line) {
            $this->info('<bg=blue;fg=white>' . $line . '</>');
        }

        $this->info('');

        return $this;
    }

    /**
     * Build the Controller Class and save in app/Http/Controllers.
     *
     * @return $this
     * @throws FileNotFoundException
     */
    protected function buildController(): static
    {
        if ($this->options['stack'] == 'livewire') {
            $this->buildLivewire();

            return $this;
        }

        $controllerPath = $this->options['stack'] == 'api'
        ? $this->_getApiControllerPath($this->name)
        : $this->_getControllerPath($this->name);

        if ($this->files->exists($controllerPath) && $this->ask('Already exist Controller. Do you want overwrite (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Creating Controller ...');

        $replace = $this->buildReplacements();

        $stubFolder = match ($this->options['stack']) {
            'api' => 'api/',
            default => ''
        };

        $controllerTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub($stubFolder . 'Controller')
        );

        $this->write($controllerPath, $controllerTemplate);

        if ($this->options['stack'] == 'api') {
            $resourcePath = $this->_getResourcePath($this->name);

            $resourceTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub($stubFolder . 'Resource')
            );

            $this->write($resourcePath, $resourceTemplate);
        }

        return $this;
    }

    protected function buildLivewire(): void
    {
        $this->info('Creating Livewire Component ...');

        $folder  = ucfirst(Str::plural($this->name));
        $replace = array_merge($this->buildReplacements(), $this->modelReplacements());

        foreach (['Index', 'Show', 'Edit', 'Create'] as $component) {
            $componentPath = $this->_getLivewirePath($folder . '/' . $component);

            $componentTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub('livewire/' . $component)
            );

            $this->write($componentPath, $componentTemplate);
        }

        // Form
        $formPath = $this->_getLivewirePath('Forms/' . $this->name . 'Form');

        $componentTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('livewire/Form')
        );

        $this->write($formPath, $componentTemplate);
    }

    /**
     * @return $this
     * @throws FileNotFoundException
     *
     */
    protected function buildModel(): static
    {
        $modelPath = $this->_getModelPath($this->name);

        if ($this->files->exists($modelPath) && $this->ask('Already exist Model. Do you want overwrite (y/n)?', 'y') == 'n') {
            return $this;
        }

        $this->info('Creating Model ...');

        // Make the models attributes and replacement
        $replace = array_merge($this->buildReplacements(), $this->modelReplacements());

        $modelTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Model')
        );

        $this->write($modelPath, $modelTemplate);

        // Make Request Class
        $requestPath = $this->_getRequestPath($this->name);

        $this->info('Creating Request Class ...');

        $requestTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Request')
        );

        $this->write($requestPath, $requestTemplate);

        return $this;
    }

    /**
     * @return $this
     * @throws FileNotFoundException
     *
     * @throws Exception
     */
    protected function buildViews(): static
    {
        if ($this->options['stack'] == 'api') {
            return $this;
        }

        $this->info('Creating Views ...');

        $tableHead = "\n";
        $tableBody = "\n";
        $viewRows  = "\n";
        $form      = "\n";

        foreach ($this->getFilteredColumns() as $column) {
            $title = Str::title(str_replace('_', ' ', $column));

            $tableHead .= $this->getHead($title);
            $tableBody .= $this->getBody($column);
            $viewRows .= $this->getField($title, $column, 'view-field');
            $form .= $this->getField($title, $column);
        }

        $replace = array_merge($this->buildReplacements(), [
            '{{tableHeader}}' => $tableHead,
            '{{tableBody}}'   => $tableBody,
            '{{viewRows}}'    => $viewRows,
            '{{form}}'        => $form,
        ]);

        $this->buildLayout();

        foreach (['index', 'create', 'edit', 'form', 'show','action'] as $view) {
            $viewTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub("views/{$this->options['stack']}/$view")
            );

            $this->write($this->_getViewPath($view), $viewTemplate);
        }

        return $this;
    }

    /**
     * Make the class name from table name.
     *
     * @return string
     */
    private function _buildClassName(): string
    {
        return Str::studly(Str::singular($this->table));
    }

    // CUSTOM FUNCTIONS
    protected function buildReplacements(): array
    {
        return [
            '{{layout}}' => $this->layout,
            '{{modelName}}' => $this->name,
            '{{modelTitle}}' => Str::title(Str::snake($this->name, ' ')),
            '{{modelTitlePlural}}' => Str::title(Str::snake(Str::plural($this->name), ' ')),
            '{{modelNamespace}}' => $this->modelNamespace,
            '{{controllerNamespace}}' => $this->controllerNamespace,
            '{{apiControllerNamespace}}' => $this->apiControllerNamespace,
            '{{resourceNamespace}}' => $this->resourceNamespace,
            '{{requestNamespace}}' => $this->requestNamespace,
            '{{livewireNamespace}}' => $this->livewireNamespace,
            '{{modelNamePluralLowerCase}}' => Str::camel(Str::plural($this->name)),
            '{{modelNamePluralUpperCase}}' => ucfirst(Str::plural($this->name)),
            '{{modelNameLowerCase}}' => Str::camel($this->name),
            '{{modelRoute}}' => $this->_getRoute(),
            '{{modelView}}' => Str::kebab($this->name),
            '{{modelViewFolder}}' => $this->getViewNamespaceFolder(),
        ];
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function _getViewPath($view): string
    {
        $name = Str::lower($this->name);
        $folder = $this->getViewNamespaceFolder();
        $path = match ($this->options['stack']) {
            'livewire' => "/views/livewire/$name/$view.blade.php",
            default => "/views/$folder/$name/$view.blade.php"
        };

        return $this->makeDirectory(resource_path($path));
    }
    protected function getViewNamespaceFolder(){
        // Get last segment
        $lastWord = class_basename($this->controllerNamespace);

        // Convert to lowercase and singular
        return Str::singular(Str::lower($lastWord));
    }

     /**
     * Make model attributes/replacements.
     *
     * @return array
     */
    protected function modelReplacements(): array
    {
        $properties = '*';
        $livewireFormProperties = '';
        $livewireFormSetValues = '';
        $rulesArray = [];
        $softDeletesNamespace = $softDeletes = '';
        $modelName = Str::camel($this->name);

        foreach ($this->getColumns() as $column) {
            $properties .= "\n * @property \${$column['name']}";

            if (! in_array($column['name'], $this->unwantedColumns)) {
                $livewireFormProperties .= "\n    public \${$column['name']} = '';";
                $livewireFormSetValues .= "\n        \$this->{$column['name']} = \$this->{$modelName}Model->{$column['name']};";
            }
            if (! $column['nullable']) {
                $rulesArray[$column['name']] = ['required'];
            }
            else{
                $rulesArray[$column['name']] = ['nullable'];
            }

            if ($column['type_name'] == 'bool') {
                $rulesArray[$column['name']][] = 'boolean';
            }

            if ($column['type_name'] == 'uuid') {
                $rulesArray[$column['name']][] = 'uuid';
            }

            if ($column['type_name'] == 'text' || $column['type_name'] == 'varchar') {
                $rulesArray[$column['name']][] = 'string';
            }

            if ($column['name'] == 'deleted_at') {
                $softDeletesNamespace = "use Illuminate\Database\Eloquent\SoftDeletes;\n";
                $softDeletes = "use SoftDeletes;\n";
            }
        }

        $rules = function () use ($rulesArray) {
            $rules = '';
            // Exclude the unwanted rulesArray
            $rulesArray = Arr::except($rulesArray, $this->unwantedColumns);
            // Make rulesArray
            foreach ($rulesArray as $col => $rule) {
                $rules .= "\n\t\t\t'$col' => '".implode('|', $rule)."',";
            }

            return $rules;
        };

        $fillable = function () {

            $filterColumns = $this->getFilteredColumns();

            // Add quotes to the unwanted columns for fillable
            array_walk($filterColumns, function (&$value) {
                $value = "'".$value."'";
            });

            // CSV format
            return implode(', ', $filterColumns);
        };

        $properties .= "\n *";

        [$relations, $properties] = (new ModelGenerator($this->table, $properties, $this->modelNamespace))->getEloquentRelations();

        return [
            '{{fillable}}' => $fillable(),
            '{{rules}}' => $rules(),
            '{{relations}}' => $relations,
            '{{properties}}' => $properties,
            '{{softDeletesNamespace}}' => $softDeletesNamespace,
            '{{softDeletes}}' => $softDeletes,
            '{{livewireFormProperties}}' => $livewireFormProperties,
            '{{livewireFormSetValues}}' => $livewireFormSetValues,
        ];
    }

}
