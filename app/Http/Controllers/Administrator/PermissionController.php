<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Hashids;

class PermissionController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['role:Admin']);

        $this->data = array(
            'active' => 'permission',
            'url1' => '/administrator/permission',
            'url2' => ''
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        \Session::put('item', '5.2:');
        $keyword = $request->get('search');
        $perPage = 25;

        $header = ([
            [
                "text" => '#',
                "align" => 'center'
            ],[
                "text" => 'id',
                "align" => 'center'
            ],[
                "text" => 'PERMISO',
                "align" => 'left'
            ]
        ]);

        if (!empty($keyword)) {
            $permission = Permission::where('name', 'LIKE', "%$keyword%")
                ->OrderBy('name','ASC')
                ->paginate($perPage);
        } else {
            $permission = Permission::paginate($perPage);
        }

    return view('administrator.permission.index', compact(['permission','header']))
                    ->with('data',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('administrator.permission.create')
                    ->with('data',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PermissionRequest $request)
    {
        $requestData = $request->all();
        Permission::create($requestData);
        toastr()->success("Una nuevo registro fue agregado",'CREACIÓN');
        return redirect('administrator/permission')->with('data',$this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $id = Hashids::decode($id)[0];
        $permission = Permission::findOrFail($id);
        return view('administrator.permission.show', compact('permission'))->with('data',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $id = Hashids::decode($id)[0];
        $permission = Permission::findOrFail($id);
        return view('administrator.permission.edit', compact('permission'))->with('data',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PermissionRequest $request, $id)
    {

        $requestData = $request->all();

        $id = Hashids::decode($id)[0];
        $permission = Permission::findOrFail($id);
        $permission->update($requestData);

        toastr()->warning("El registro fue actualizado",'ACTUALIZACIÓN');

        return redirect('administrator/permission')
                        ->with('data',$this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $id = Hashids::decode($id)[0];
        $permission = Permission::findOrFail($id);
        $permission->delete();
        toastr()->error("El registro fue eliminado",'ELIMINACIÓN');
        return redirect('administrator/permission')->with('data',$this->data);
    }
}
