<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('authors.index');
        $columns = [
            [
                "data" => "id",
                "name" => "id",
                "title" => "Id"
            ],
                [
                "data" => "name",
                "name" => "name",
                "title" => "Name"
            ],
                [
                "data" => "activated",
                "name" => "activated",
                "title" => "Activated"
            ],
                [
                "data" => "updated_at",
                "name" => "updated_at",
                "title" => "Updated At"
            ],
            
        ];

        return view('koaladmin.authors.index', compact('columns'));
    }
}
