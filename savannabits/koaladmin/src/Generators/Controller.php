<?php namespace Savannabits\Koaladmin\Generators;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Savannabits\Koaladmin\Generators\Traits\FileManipulations;
use Illuminate\Support\Str;
use Savannabits\Koaladmin\Helpers\KoalaHelper;
use Symfony\Component\Console\Input\InputOption;

class Controller extends ClassGenerator {

    use FileManipulations;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'koala:generate:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a web controller class';

    /**
     * Path for view
     *
     * @var string
     */
    protected $view = 'controller';

    /**
     * Controller has also export method
     *
     * @return mixed
     */
    protected $export = false;

    /**
     * Controller has also bulk options method
     *
     * @return mixed
     */
    protected $withoutBulk = false;
    protected $modelTitle;

    public function handle()
    {
        $force = $this->option('force');

        if($this->option('with-export')){
            $this->export = true;
        }

        if($this->option('without-bulk')){
            $this->withoutBulk = true;
        }
        // TODO test the case, if someone passes a class_name outside Laravel's default App\Http\Controllers folder, if it's going to work

        //TODO check if exists
        //TODO make global for all generator
        //TODO also with prefix
        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.controller';
        }

        if(!empty($belongsToMany = $this->option('belongs-to-many'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }

        if ($this->generateClass($force)){

            $this->info('Generating '.$this->classFullName.' finished');

            $icon = "fas fa-folder ml-auto";
            $item = [
                "slug" => Str::slug($this->titlePlural),
                "title" => $this->titlePlural,
                "icon_class" => $icon,
                "route_name" => config('koaladmin.prefix').".".$this->modelRouteAndViewName.".index",
                "permission_name" => $this->modelRouteAndViewName,
                "has_children" => false,
                "children" => []
            ];
            $write = KoalaHelper::pushItemToJsonMenu($item);
            if ($write) {
                $this->info('Side Menu has been updated in the .json file at the root of the project');
            } elseif(is_null($write)) {
                $this->warn("Side menu already existed and has been skipped");
            }
            else {
                $this->error("Error while appending menu item to .json menu file at the root of the project.");
            }
        }

    }

    protected function buildClass() {

        //Set belongsTo Relations
        $this->relations["belongsTo"] = collect(\Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($this->tableName))->map(function($fk) {
            /**@var ForeignKeyConstraint $fk*/
            return [
                "function_name" => Str::camel(Str::singular($fk->getForeignTableName())),
                "related_table" => $fk->getForeignTableName(),
                "related_model" => "\\$this->modelNamespace\\". Str::studly(Str::singular($fk->getForeignTableName())).'::class',
                "foreign_key" => collect($fk->getColumns())->first(),
                "owner_key" => collect($fk->getForeignColumns())->first(),
            ];
        })->keyBy('related_table');
        $this->modelTitle = str_replace("_"," ", Str::title($this->tableName));
        return view('koala::'.$this->view, [
            'controllerBaseName' => $this->classBaseName,
            'controllerNamespace' => $this->classNamespace,
            'modelBaseName' => $this->modelBaseName,
            'modelFullName' => $this->modelFullName,
            'modelPlural' => $this->modelPlural,
            'modelTitle' => $this->modelTitle,
            'modelVariableName' => $this->modelVariableName,
            'modelRouteAndViewName' => $this->modelRouteAndViewName,
            'modelViewsDirectory' => $this->modelViewsDirectory,
            'modelDotNotation' => $this->modelDotNotation,
            'modelWithNamespaceFromDefault' => $this->modelWithNamespaceFromDefault,
            'export' => $this->export,
            'withoutBulk' => $this->withoutBulk,
            'exportBaseName' => $this->exportBaseName,
            'resource' => $this->resource,
            'containsPublishedAtColumn' => in_array("published_at", array_column($this->readColumnsFromTable($this->tableName)->toArray(), 'name')),
            // index
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                if($this->readColumnsFromTable($this->tableName)->contains('name', 'created_by_admin_user_id')){
                    return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "updated_at" || $column['name'] == "deleted_at");
                } else if($this->readColumnsFromTable($this->tableName)->contains('name', 'updated_by_admin_user_id')) {
                    return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "created_at" ||  $column['name'] == "deleted_at");
                } else if($this->readColumnsFromTable($this->tableName)->contains('name', 'created_by_admin_user_id') && $this->readColumnsFromTable($this->tableName)->contains('name', 'updated_by_admin_user_id')) {
                    return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "deleted_at");
                }
                return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "created_at" || $column['name'] == "deleted_at"||Str::contains($column['name'],"_id"));
            })->pluck('name')->toArray(),
            'columnsToSearchIn' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return ($column['type'] == 'json' || $column['type'] == 'text' || $column['type'] == 'string' || $column['name'] == "id") && !($column['name'] == "password" || $column['name'] == "remember_token");
            })->pluck('name')->toArray(),
            //            'filters' => $this->readColumnsFromTable($tableName)->filter(function($column) {
            //                return $column['type'] == 'boolean' || $column['type'] == 'date';
            //            }),
            // validation in store/update
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'relations' => $this->relations,
            'hasSoftDelete' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                    return $column['name'] == "deleted_at";
            })->count() > 0,
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Generates a code for the given model'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongs-to-many', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating controller'],
            ['model-with-full-namespace', 'fnm', InputOption::VALUE_OPTIONAL, 'Specify model with full namespace'],
            ['with-export', 'e', InputOption::VALUE_NONE, 'Generate an option to Export as Excel'],
            ['without-bulk', 'wb', InputOption::VALUE_NONE, 'Generate without bulk options'],
        ];
    }

    public function generateClassNameFromTable($tableName) {
        return Str::studly(Str::singular($tableName)).'Controller';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Admin';
    }
}
