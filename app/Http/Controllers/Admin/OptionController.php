<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\Option\OptionRepository;
use App\Http\Requests\Admin\Option\CreateOptionRequest;
use App\Http\Requests\Admin\Option\UpdateOptionRequest;
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
        $this->options->create($data);
        return redirect()->route('admin.option')
            ->withSuccess(trans('app.option_created'));
    }

    public function edit(Option $option)
    {
        $edit = true;
        return view('admin.option.add-edit',compact('edit','option'));
    }

    public function update(Option $option,UpdateOptionRequest $request)
    {
        $this->options->update($option->id,$request->all());
        return redirect()->route('admin.option')
            ->withSuccess(trans('app.option_updated'));
    }

    public function delete(Option $option)
    {

        $this->options->delete($option->id);

        return redirect()->route('admin.option')
            ->withSuccess(trans('app.option_deleted'));
    }

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
