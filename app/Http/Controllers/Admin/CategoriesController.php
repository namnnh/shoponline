<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;

class CategoriesController extends Controller
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $perPage = 20;
        $categories = $this->categories->paginate($perPage,Input::get('search'));
        return view('admin.category.list',compact('categories'));
    }

    public function create()
    {
        $edit = false;
        $categories = $this->parseCategories($this->categories);
        return view('admin.category.add-edit',compact('edit','categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->all();
        $this->categories->create($data);
        return redirect()->route('admin.category')
            ->withSuccess(trans('app.user_created'));
    }

    /**
	* Private function
	*/
	private function parseCategories(CategoryRepository $categoryRepository){
		return [0 => 'Root'] + $categoryRepository->lists()->toArray();
	}
}
