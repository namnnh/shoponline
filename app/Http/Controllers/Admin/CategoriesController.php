<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Category;

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
            ->withSuccess(trans('app.category_created'));
    }

    public function edit(Category $category)
    {
        $edit = true;
        $categories = $this->parseCategories($this->categories,$category->id);
        return view('admin.category.add-edit',compact('edit','category','categories'));
    }

    public function update(Category $category,UpdateCategoryRequest $request)
    {
        $this->categories->update($category->id,$request->all());
        return redirect()->route('admin.category')
            ->withSuccess(trans('app.category_updated'));
    }

    /**
	* Private function
	*/
	private function parseCategories(CategoryRepository $categoryRepository, $id = null){
        if($id)
        {
            return [0 => 'Root'] + $categoryRepository->listsExpectItself($id)->toArray();
        }else{
            return [0 => 'Root'] + $categoryRepository->lists()->toArray();
        }
	}
}
