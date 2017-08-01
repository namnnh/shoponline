<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\Option\OptionRepository;
use App\Http\Requests\Admin\Option\CreateOptionRequest;
use App\Option;
use Validator;

class OptionController extends Controller
{
    private $options;

    public function __construct(OptionRepository $option)
    {
        $this->options = $option;
    }

    public function index()
    {
        $perPage = 20;
        $options = $this->options->paginate($perPage,Input::get('search'));
        return view('admin.option.list',compact('options'));
    }

    public function create()
    {
        $edit = false;
        return view('admin.option.add-edit',compact('edit'));
    }

    public function store(CreateOptionRequest $request)
    {
        $data = $request->all();
        $this->checkOptionValue($data['option_value']);
        // $this->categories->create($data);
        // return redirect()->route('admin.category')
        //     ->withSuccess(trans('app.category_created'));
        dd($request->all());
    }

    // public function edit(Category $category)
    // {
    //     $edit = true;
    //     $categories = $this->parseCategories($this->categories,$category->id);
    //     return view('admin.category.add-edit',compact('edit','category','categories'));
    // }

    // public function update(Category $category,UpdateCategoryRequest $request)
    // {
    //     $this->categories->update($category->id,$request->all());
    //     return redirect()->route('admin.category')
    //         ->withSuccess(trans('app.category_updated'));
    // }

    /**
	* Private function
	*/
	// private function parseCategories(CategoryRepository $categoryRepository, $id = null){
 //        if($id)
 //        {
 //            return [0 => 'Root'] + $categoryRepository->listsExpectItself($id)->toArray();
 //        }else{
 //            return [0 => 'Root'] + $categoryRepository->lists()->toArray();
 //        }
	// }

	private function checkOptionValue(array $option_value)
	{
		foreach($option_value as $value)
		{
			 $validator = Validator::make(
		       	['option_value_item' => $value['name']],
            	['option_value_item' => 'required']
		    )->validate();
		}
	}
}
