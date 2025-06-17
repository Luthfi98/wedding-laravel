<?php

namespace App\Http\Controllers\Cms;

use App\Models\Role;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view user', only: ['index', 'getData', 'show']),
            new Middleware('permission:create user', only: ['create', 'store']),
            new Middleware('permission:update user', only: ['edit', 'update']),
            new Middleware('permission:delete user', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Users')
        ];
        return view('cms.users.index')->with($data);
    }

    public function getData(Request $request)
    {
        if($request->ajax()) {
            
            $users = User::query();
            if ($request->status != null) {
                $users->where('status', $request->status);
            }
    
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()->first();
                })
                ->addColumn('DT_RowIndex', function ($user) {
                    return $user->id;
                })
                ->addColumn('action', function ($user) {
                    $btns = [];
                    if (auth()->user()->can('update user')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('users.edit', $user->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    if (auth()->user()->can('delete user')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $user->id . '"
                        data-route="'.route('users.delete', $user->id).'"
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
                    return '';
                })
                ->addColumn('status', function ($user) {
                    $badge = 'danger';
                    $label = 'Inactive';
                    if ($user->status === 'active') {
                        $badge = 'success';
                        $label = 'Active';
                    }
                    return '<span class="badge bg-' . $badge . '">' . $label . '</span>';
                })
                ->rawColumns(['action', 'status'])
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
            'title' => 'Create User',
            'roles' => Role::all()
        ];
        return view('cms.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'status' => $validated['status']
            ]);

            LogActivity::insertData($user->toArray(), $user->getTable());


            $user->assignRole($validated['role_id']);

            LogActivity::insertData($user->getRoleNames()->first(), 'role');

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create user. ' . $e->getMessage());
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
        $user = User::findOrFail($id);
        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => Role::all()
        ];
        return view('cms.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => $validated['status']
            ];

            // Only update password if it's provided
            if (!empty($validated['password'])) {
                $updateData['password'] = bcrypt($validated['password']);
            }

            $user->update($updateData);
            LogActivity::insertData($updateData, $user->getTable());


            $user->syncRoles($validated['role_id']);
            LogActivity::insertData($user->getRoleNames()->toArray(), 'role');
            
            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update user. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete user. ' . $e->getMessage()
            ], 500);
        }
    }
}
