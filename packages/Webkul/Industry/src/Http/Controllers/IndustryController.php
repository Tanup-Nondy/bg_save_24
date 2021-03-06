<?php

namespace Webkul\Industry\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Webkul\Industry\Repositories\IndustryRepository;


//use Webkul\Industry\Repositories\IndustryRepository;

class IndustryController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $industryRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @return void
     */
    public function __construct(IndustryRepository $industryRepository)
    {
        $this->industryRepository = $industryRepository;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'code'       => ['required', 'unique:related_industries'],
        ]);

        $data = request()->all();
        //$code=strtolower($data->name);

        //$data['code'] = $code;
        //foreach ($data as $key ) {
           // echo $key;
        //}
        $industry = $this->industryRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Industry']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $industry = $this->industryRepository->findOrFail($id);
        
        return view($this->_config['view'], compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'admin_name' => 'required',
        ]);

        $industry = $this->industryRepository->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Industry']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $industry = $this->industryRepository->findOrFail($id);

        try {
            $this->industryRepository->delete($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Industry']));

            return response()->json(['message' => true], 200);
        } catch(\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Industry']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Remove the specified resources from database
     *
     * @return \Illuminate\Http\Response
     */
    /*public function massDestroy()
    {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            $indexes = explode(',', request()->input('indexes'));

            foreach ($indexes as $key => $value) {
                $attribute = $this->industryRepository->find($value);

                try {
                    if ($attribute->is_user_defined) {
                        $suppressFlash = true;

                        $this->industryRepository->delete($value);
                    } else {
                        session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Attribute']));
                    }
                } catch (\Exception $e) {
                    report($e);

                    $suppressFlash = true;

                    continue;
                }
            }

            if ($suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'attributes']));
            } else {
                session()->flash('info', trans('admin::app.datagrid.mass-ops.partial-action', ['resource' => 'attributes']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }*/
}