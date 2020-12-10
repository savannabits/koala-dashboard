<?php namespace Savannabits\Koaladmin\Generators;

use Illuminate\Support\Str;
use Savannabits\Koaladmin\Generators\Traits\FileManipulations;
use Symfony\Component\Console\Input\InputOption;

class Routes extends FileAppender {

    use FileManipulations;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'koala:generate:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Append admin routes into a web routes file';

    /**
     * Path for view
     *
     * @var string
     */
    protected $view = 'routes';

    /**
     * Routes have also export route
     *
     * @return mixed
     */
    protected $export = false;

    /**
     * Routes have also bulk options route
     *
     * @return mixed
     */
    protected $withoutBulk = false;

    public function handle()
    {
        if($this->option('with-export')){
            $this->export = true;
        }

        if($this->option('without-bulk')){
            $this->withoutBulk = true;
        }

        //TODO check if exists
        //TODO make global for all generator
        //TODO also with prefix
        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.routes';
        }
        $ifExistsReg = '|group\(base_path\(\'routes\/koaladmin\.php\'\)\)|';
        $replace = PHP_EOL.'
        Route::middleware(\'web\')
                ->namespace($this->namespace)
                ->group(base_path(\'routes/koaladmin.php\'));
        '.PHP_EOL;
        if ($this->strReplaceInFile(
            base_path("app/Providers/RouteServiceProvider.php"),
            $ifExistsReg,
        '$this->routes(function () {',
        '$this->routes(function () {'.$replace,
        )) {
            $this->info('Updated Route Service Provider');
        }
        if ($this->appendIfNotAlreadyAppended(base_path('routes/koaladmin.php'), PHP_EOL.PHP_EOL.$this->buildClass())){
            $this->info('Appending routes finished');
        }
    }

    protected function buildClass($api=false) {
        return view('koala::'.$this->view, [
            'controllerClassName' => class_basename($this->controllerWithNamespaceFromDefault),
            'controllerFullName' => $this->controllerFullName,
            'controllerPartiallyFullName' => $this->controllerWithNamespaceFromDefault,
            'modelRouteName' => Str::plural($this->modelRouteAndViewName),
            'modelVariableName' => $this->modelVariableName,
            'modelViewsDirectory' => $this->modelViewsDirectory,
            'resource' => $this->resource,
            'export' => $this->export,
            'withoutBulk' => true,
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a controller for the given model'],
            ['controller-name', 'c', InputOption::VALUE_OPTIONAL, 'Specify custom controller name'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
        ];
    }

}
