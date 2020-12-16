<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Author\IndexAuthor;
use App\Http\Requests\Api\Author\StoreAuthor;
use App\Http\Requests\Api\Author\UpdateAuthor;
use App\Models\Author;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Savannabits\Koaladmin\Helpers\ApiResponse;
use Savannabits\Koaladmin\Helpers\SavbitsHelper;
use Yajra\DataTables\Facades\DataTables;

class AuthorController  extends Controller
{
    private $api, $helper;
    public function __construct(ApiResponse $apiResponse, SavbitsHelper $helper)
    {
        $this->api = $apiResponse;
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource (paginated).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexAuthor $request)
    {
        $data = $this->helper::listing(Author::class, $request)->customQuery(function ($builder) use($request) {
        /**@var  Author|Builder $builder*/
        // Add custom queries here
        })->process();
        return $this->api->success()->message("List of Authors")->payload($data)->send();
    }

    public function dt(Request $request) {
        return DataTables::of(Author::query())
            ->addColumn("actions",function($model) {
                $actions = '';
                if (\Auth::user()->can('authors.show')) $actions    .= '<button class="action-button btn shadow-none border p-2 py-1 rounded-none mr-2 text-primary border-primary hover:bg-primary hover:text-gray-200" title="View Details" data-action="show-author" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('authors.edit')) $actions    .= '<button class="action-button btn shadow-none border p-2 py-1 rounded-none mr-2 text-warning border-warning hover:bg-warning hover:text-gray-200" title="Edit Item" data-action="edit-author" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('authors.delete')) $actions  .= '<button class="action-button btn shadow-none border p-2 py-1 rounded-none mr-2 text-danger border-danger hover:bg-danger hover:text-gray-200" title="Delete Item" data-action="delete-author" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-trash"></i></button>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAuthor $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAuthor $request)
    {
        try {
            $array = $request->sanitizedArray();
            $author = new Author($array);

            // Save Relationships
            $object = $request->sanitizedObject();


            $author->saveOrFail();
            return $this->api->success()->message('Author Created')->payload($author)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Author $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Author $author)
    {
        try {
            //Fetch relationships
                        return $this->api->success()->message("Author $author->id")->payload($author)->send();
        } catch (\Throwable $exception) {
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAuthor $request
     * @param {$modelBaseName} $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAuthor $request, Author $author)
    {
        try {
            $data = $request->sanitizedArray();
            $author->update($data);

            // Save Relationships
                $object = $request->sanitizedObject();


            $author->saveOrFail();
            return $this->api->success()->message("Author has been updated")->payload($author)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Author $author)
    {
        try {
            $this->authorize('authors.delete');
            $author->delete();
            return $this->api->success()->message("Author has been deleted")->payload($author)->code(200)->send();
        } catch(AuthorizationException $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(403)->message($exception->getMessage())->send();
        } catch(\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

}
