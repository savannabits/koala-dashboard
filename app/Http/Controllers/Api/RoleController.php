<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\IndexRole;
use App\Http\Requests\Api\Role\StoreRole;
use App\Http\Requests\Api\Role\UpdateRole;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Savannabits\Koaladmin\Helpers\ApiResponse;
use Savannabits\Koaladmin\Helpers\SavbitsHelper;
use Yajra\DataTables\Facades\DataTables;

class RoleController  extends Controller
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
    public function index(IndexRole $request)
    {
        $data = $this->helper::listing(Role::class, $request)->customQuery(function ($builder) use($request) {
        /**@var  Role|Builder $builder*/
        // Add custom queries here
        })->process();
        return $this->api->success()->message("List of Roles")->payload($data)->send();
    }

    public function dt(Request $request) {
        return DataTables::of(Role::query())
            ->addColumn("actions",function($model) {
                $actions = '';
                if (\Auth::user()->can('roles.show')) $actions .= '<button class="btn bg-primary mr-2" title="View Details" data-action="show-role" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('roles.edit')) $actions .= '<button class="btn bg-warning mr-2" title="Edit Item" data-action="edit-role" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('roles.delete')) $actions .= '<button class="btn bg-danger mr-2" title="Delete Item" data-action="delete-role" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-trash"></i></button>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRole $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRole $request)
    {
        try {
            $array = $request->sanitizedArray();
            $role = new Role($array);
            
            // Save Relationships
            $object = $request->sanitizedObject();
                        

            $role->saveOrFail();
            return $this->api->success()->message('Role Created')->payload($role)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Role $role)
    {
        try {
            //Fetch relationships
                        return $this->api->success()->message("Role $role->id")->payload($role)->send();
        } catch (\Throwable $exception) {
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRole $request
     * @param {$modelBaseName} $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRole $request, Role $role)
    {
        try {
            $data = $request->sanitizedArray();
            $role->update($data);
            
            // Save Relationships
                $object = $request->sanitizedObject();
                

            $role->saveOrFail();
            return $this->api->success()->message("Role has been updated")->payload($role)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Role $role)
    {
        try {
            $request->authorize('delete',$role);
            $role->delete();
            return $this->api->success()->message("Role has been deleted")->payload($role)->code(200)->send();
        } catch(AuthorizationException $e) {
            \Log::error($exception);
            return $this->api->failed()->code(403)->message($exception->getMessage())->send();
        } catch(\Throwable $e) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

}
