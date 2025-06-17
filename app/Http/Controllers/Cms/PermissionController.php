<?php

namespace App\Http\Controllers\Cms;

use App\Models\Menu;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use App\Models\LogActivity;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view menu', only: ['index', 'getData', 'show']),
            new Middleware('permission:create menu', only: ['create', 'store']),
            new Middleware('permission:update menu', only: ['edit', 'update']),
            new Middleware('permission:delete menu', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Permissions'),
            'menus' => Menu::orderBy('name')->get(),
            'guards' => Permission::select('guard_name')->distinct()->pluck('guard_name')
        ];
        return view('cms.permissions.index')->with($data);
    }

    /**
     * Get permissions data for DataTables
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = Permission::select('permissions.*')->with('menu');
            if ($request->filled('menu')) {
                $query->where('menu_id', $request->menu);
            }

            if ($request->filled('guard')) {
                $query->where('guard_name', $request->guard);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($permission) {
                    $btns = [];
                    if (auth()->user()->can('update permission')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('permissions.edit', $permission->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    if (auth()->user()->can('delete permission')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                            data-id="' . $permission->id . '"
                            data-route="permissions/delete/'.$permission->id.'"
                            data-dt="permissions-table"
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
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json(['error' => 'Invalid request'], 400);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Permissions'),
            'menus' => Menu::orderBy('name')->get(),
            'guards' => Permission::select('guard_name')->distinct()->pluck('guard_name')
        ];
        return view('cms.permissions.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'menu_id' => 'required|exists:menus,id',
            'guard_name' => 'required|string|min:3|max:15',
        ]);

        try {
            DB::beginTransaction();

            $permission = Permission::create([
                'name' => $validated['name'],
                'menu_id' => $validated['menu_id'],
                'guard_name' => $validated['guard_name'],
            ]);

            LogActivity::insertData($permission->toArray(), $permission->getTable());

            DB::commit();

            return redirect()
                ->route('permissions.index')
                ->with('success', __('Permission created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to create permission. ') . $e->getMessage());
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
        $data = [
            'title' => __('Permissions'),
            'permission' => Permission::findOrFail($id),
            'menus' => Menu::orderBy('name')->get(),
            'guards' => Permission::select('guard_name')->distinct()->pluck('guard_name')
        ];
        return view('cms.permissions.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'menu_id' => 'required|exists:menus,id',
            'guard_name' => 'required|string|min:3|max:15',
        ]);

        try {
            DB::beginTransaction();

            $permission = Permission::findOrFail($id);
            $permission->update([
                'name' => $validated['name'],
                'menu_id' => $validated['menu_id'],
                'guard_name' => $validated['guard_name'],
            ]);

            LogActivity::insertData($permission->toArray(), $permission->getTable());

            DB::commit();

            return redirect()
                ->route('permissions.index')
                ->with('success', __('Permission updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to update permission. ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $permission = Permission::findOrFail($id);
            
            // Get roles that use this permission
            $roles = $permission->roles;
            
            // Detach the permission from all roles
            foreach ($roles as $role) {
                $role->permissions()->detach($permission->id);
            }
            
            // Delete the permission
            $permission->delete();

            LogActivity::insertData([
                'permission' => $permission->toArray(),
                'affected_roles' => $roles->pluck('name')->toArray()
            ], 'permissions');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => __('Permission deleted successfully.')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => __('Failed to delete permission. ') . $e->getMessage()
            ], 500);
        }
    }
}
