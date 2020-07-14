<?php

namespace App\Http\Controllers\iPanel;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "إدارة الادوار";
        $roles = Role::paginate(10);
        $permissions = Permission::all();
        return view('ipanel.roles.index', compact(['title', 'roles', 'permissions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name',
                'permissions' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator);
            } else {
                $role = new Role();
                $role->name = $request->input('name');

                $input = $request->except('permissions');
                $permissions = $request->input('permissions');


                if (!$role->fill($input)->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger']);
                }

                $p_all = Permission::all();//Get all permissions
                foreach ($p_all as $p) {
                    $role->revokePermissionTo($p); //Remove all permissions associated with role
                }

                foreach ($permissions as $permission) {
                    $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
                    $role->givePermissionTo($p);  //Assign permission to role
                }

                $this->setLog('قام بإضافة الدور ' . $request->input('name'));
                return redirect(url(route('roles.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $title = "تعديل الدور";
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('ipanel.roles.show', compact(['title', 'role', 'permissions']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->isMethod('post')) {
            $role = Role::find($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,' . $id
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                    ->withErrors($validator);
            } else {
                $role->name = $request->input('name');

                if (!$role->save()) {
                    return redirect()
                        ->back()
                        ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger']);
                }
                $this->setLog('قام بتعديل الدور ' . $role->name);

                return redirect(url(route('roles.index')))->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        //
        $role = Role::find($id);
        $validator = Validator::make($request->all(), [
            'permissions' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger'])
                ->withErrors($validator);
        } else {

            $input = $request->except('permissions');
            $permissions = $request->input('permissions');


            if (!$role->fill($input)->save()) {
                return redirect()
                    ->back()
                    ->with(['message' => 'لم تتم العملية بنجاح للأسباب التالية.', 'type' => 'alert-danger']);
            }

            $p_all = Permission::all();//Get all permissions
            foreach ($p_all as $p) {
                $role->revokePermissionTo($p); //Remove all permissions associated with role
            }

            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
                $role->givePermissionTo($p);  //Assign permission to role
            }
            $this->setLog('قام بتعديل الصلاحيات لدور ' . $role->name);

            return redirect()->back()->with(['message' => 'تمت العملية بنجاح', 'type' => 'alert-success']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $role = Role::find($id);
        if (!$role) {
            return redirect(route('roles.index'))
                ->with(['message' => 'لم تتم العملية بنجاح.', 'type' => 'alert-danger']);
        }


        $this->setLog('قام بحذف الدور ' . $role->name);
        $role->forceDelete();
        return redirect(route('roles.index'))
            ->with(['message' => 'تمت العملية بنجاح.', 'type' => 'alert-success']);
    }

    private function setLog($msg)
    {
        $user = Auth::user();
        $log = New Log();
        $log->user_id = $user->id;
        $log->log_message = $msg;
        if (!$log->save()) {
            return redirect()->back()->with(['message' => 'لم يتم تسجيل العملية', 'type' => 'alert-danger']);
        }
    }


}
