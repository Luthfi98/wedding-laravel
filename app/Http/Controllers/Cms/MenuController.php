<?php

namespace App\Http\Controllers\Cms;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class MenuController extends Controller implements HasMiddleware
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
    private function access() {
        return [
            'view', 'detail' ,'create', 'update', 'delete', 'import', 'export', 'print', 'download'
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Menus')
        ];
        return view('cms.menus.index')->with($data);
    }


    public function getData(Request $request)
    {
        if($request->ajax()) {
            
            $menus = Menu::select('menus.*', 'parent.name as parent_name')
                ->leftJoin('menus as parent', 'menus.parent_id', '=', 'parent.id');
            if ($request->status != null) {
                $menus->where('status', $request->status);
            }
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($menu) {
                    return $menu->id;
                })
                ->editColumn('route', function ($menu) {
                    return $menu->route ? "<a href='" . route($menu->route) . "' target='_blank' class='text-decoration-none text-primary'>" . $menu->route . "</a>" : '-';
                })
                ->editColumn('icon', function ($menu) {
                    return '<i class="' . $menu->icon . '"></i>';
                })

                ->addColumn('action', function ($menu) {
                    $btns = [];
                    if (auth()->user()->can('update menu')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('menus.edit', $menu->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    if (auth()->user()->can('delete menu')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $menu->id . '"
                        data-route="menus/delete/'.$menu->id.'"
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
                ->addColumn('status', function ($menu) {
                    $badge = 'danger';
                    $label = 'Inactive';
                    if ($menu->status === 'active') {
                        $badge = 'success';
                        $label = 'Active';
                    }
                    return '<span class="badge bg-' . $badge . '">' . $label . '</span>';
                })
                ->rawColumns(['action', 'status', 'icon', 'route'])
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
            'title' => __('Add Menu'),
            'parents' => Menu::where('parent_id', null)->get(),
            'access' => $this->access()
        ];
        return view('cms.menus.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module_name' => 'required|string|max:255|unique:menus,module_name',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:menus,id',
            'status' => 'required|in:active,inactive',
            'list_permissions' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();
            $dataMenu = $request->only([
                'name', 'module_name', 'icon', 'route', 'order', 'parent_id', 'status', 'list_permissions'
            ]) + ['order' => $request->order ?? 0];
            $menu = Menu::create($dataMenu);

            LogActivity::insertData($dataMenu, $menu->getTable());


            // dd($request->list_permissions);
            if ($request->list_permissions) {
                $permissions = collect($request->list_permissions)->map(function ($key) use ($menu) {
                    return [
                        'name' => $key . ' ' . strtolower($menu->module_name),
                        'guard_name' => 'web',
                        'menu_id' => $menu->id
                    ];
                });
            }else{
                $permissions[] = [
                    'name' => strtolower($menu->module_name),
                    'guard_name' => 'web',
                    'menu_id' => $menu->id
                ];
            }
            
            foreach ($permissions as $permissionData) {
                $permission = Permission::firstOrCreate($permissionData);
                $menu->permissions()->save($permission);
            }
            $permissions = (array) $permissions;

            LogActivity::insertData($permissions, $permission->getTable());


            

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', __('Menu created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Menu creation failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to create menu. Please try again.'));
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
            'title' => 'Edit Menu',
            'menu' => Menu::findOrFail($id),
            'parents' => Menu::where('parent_id', null)->get(),
            'access' => $this->access()
        ];

        return view('cms.menus.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module_name' => 'required|string|max:255|unique:menus,module_name,' . $id,
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:menus,id',
            'status' => 'required|in:active,inactive',
            'list_permissions' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();
            
            $menu = Menu::findOrFail($id);

            $dataMenu = $request->only([
                'name', 'module_name', 'icon', 'route', 'order', 'parent_id', 'status', 'list_permissions'
            ]) + ['order' => $request->order ?? 0];

            $menu->update($dataMenu);

            LogActivity::insertData($dataMenu, $menu->getTable());



            if ($request->list_permissions) {
                $permissions = collect($request->list_permissions)->map(function ($key) use ($menu) {
                    return [
                        'name' => $key . ' ' . strtolower($menu->module_name),
                        'guard_name' => 'web',
                        'menu_id' => $menu->id
                    ];
                });
            }else{
                $permissions[] = [
                    'name' => strtolower($menu->module_name),
                    'guard_name' => 'web',
                    'menu_id' => $menu->id
                ];
            }
            
            
            
            $permit = Permission::where('menu_id', $menu->id)
            ->where(function ($query) use ($permissions) {
                if (count($permissions) == 1) {
                    $query->orWhere('name', $permissions[0]['name']);
                }else{
                    foreach ($permissions??[] as $permission) {
                        $query->orWhere('name', 'like', '%' . $permission['name'] . '%');
                    }
                }
            })
            ->get();
            $permitId = $permit->pluck('id')->toArray();
            
            
            // $permit = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')->where('menu_id', $menu->id)
            //     ->get()
            //     ->groupBy('role_id');

            // Update permissions
            

            // dd($permitId);

            // Delete old permissions
            Permission::whereNotIn('id', $permitId)->where('menu_id', $menu->id)->delete();
            // dd($permitId);
            
            foreach ($permissions as $permissionData) {
                $permission = Permission::updateOrCreate(['menu_id' => $menu->id, 'name' => $permissionData['name']], $permissionData);
                $menu->permissions()->save($permission);
                // dd($menu->permissions()->save($permission));
            }

            $permissions = (array) $permissions;

            LogActivity::insertData($permissions, $permission->getTable());

            

            // // Reassign permission to role
            // $roles = Role::whereIn('id', $permit->keys())->get();
            // foreach ($roles as $role) {
            //     $role->permissions()->syncWithoutDetaching($menu->permissions->pluck('id'));
            // }



            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', __('Menu updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Menu update failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to update menu. Please try again.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $menu = Menu::findOrFail($id);
            $permissions = $menu->permissions()->get();
            $menu->permissions()->delete();
            LogActivity::insertData($permissions->toArray(), 'permissions');
            
            $menu->delete();
            LogActivity::insertData($menu->toArray(), $menu->getTable());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => __('Menu deleted successfully')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Menu delete failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => __('Failed to delete menu. Please try again.')
            ], 500);
        }
    }

    /**
     * Show the menu sorting interface
     */
    public function sorting()
    {
        $data = [
            'title' => __('Menu Sorting'),
            'menus' => Menu::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->orderBy('order');
                }])
                ->orderBy('order')
                ->get()
        ];

        // dd($data['menus']);
        return view('cms.menus.sorting')->with($data);
    }

    /**
     * Update the order of menus
     */
    public function updateOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->order);

            foreach ($request->order as $item) {
                Menu::where('id', $item['id'])->update(['order' => $item['order'], 'parent_id' => null]);
                if (isset($item['children'])) {
                    foreach ($item['children'] as $child) {
                        Menu::where('id', $child['id'])->update(['order' => $child['order'], 'parent_id' => $item['id']]);
                    }   
                }
            }

            LogActivity::insertData($request->order, 'menus');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Menu order updated successfully')
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Menu order update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => __('Failed to update menu order')
            ], 500);
        }
    }
}

