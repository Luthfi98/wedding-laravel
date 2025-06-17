<?php

namespace App\Http\Controllers\CMS;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index', 'getData', 'show']),
            new Middleware('permission:create role', only: ['create', 'store']),
            new Middleware('permission:update role', only: ['edit', 'update']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Roles'),
            'guards' => Role::select('guard_name')->distinct()->get()
        ];
        return view('cms.roles.index')->with($data);
    }

    public function getData(Request $request)
    {
        if($request->ajax()) {
            
            $roles = Role::query();
            if ($request->guard != null) {
                $roles->where('guard_name', $request->guard);
            }
    
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($role) {
                    return $role->id;
                })
                ->addColumn('action', function ($role) {
                    $btns = [];
                    if (auth()->user()->can('update role')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('roles.edit', $role->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    if (auth()->user()->can('delete role')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $role->id . '"
                        data-route="'.route('roles.delete', $role->id).'"
                        data-dt="dataTable"
                        onclick="deleteData(this)"><i class="bi bi-trash"></i> Delete</button></li>';
                    }
                    if (!empty($btns)) {
                        return '<div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                ' . implode('', $btns) . '
                            </ul>
                        </div>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Role',
            
        ];
        return view('cms.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string|min:3|max:15',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'],
            ]);

            LogActivity::insertData($role->toArray(), $role->getTable());


            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create role. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $menus = Menu::orderBy('order')->pluck('name', 'id')->toArray();

        $permissions = [];
        foreach($menus as $key => $menu){
            $permissions[$menu] = Permission::where('menu_id', $key)->get();
        }
        $data = [
            'title' => 'Edit Role',
            'role' => $role,
            'permissions' => $permissions
        ];
        return view('cms.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'guard_name' => 'required|string|min:3|max:15'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name']
            ]);

            LogActivity::insertData($role->toArray(), $role->getTable());
            
            
            $role->permissions()->sync($request->input('permissions', []));
            LogActivity::insertData($request->input('permissions', []), 'role_has_permissions');

            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update role. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->permissions()->detach();
            $role->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete role. ' . $e->getMessage()
            ], 500);
        }
    }
}
