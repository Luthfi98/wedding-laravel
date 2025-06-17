<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\Setting;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view setting', only: ['index', 'data', 'show']),
            new Middleware('permission:update setting', only: ['edit', 'update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Settings')
        ];
        return view('cms.settings.index')->with($data);
    }

    /**
     * Get data for DataTable
     */
    public function getData(Request $request)
    {
        $query = Setting::query();

        // Filter by status if provided
        // dd($request->status);
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }
        

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $badge = ($row->status === 'active') ? 'success' : 'danger';
                $label = ucfirst($row->status);
                return '<span class="badge bg-' . $badge . '">' . $label . '</span>';
            })

            ->addColumn('action', function ($row) {
                $btns = [];
                
                if (auth()->user()->can('update setting')) {
                    $btns[] = '<li><a class="dropdown-item" href="' . route('settings.edit', $row->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                }
                
                if (auth()->user()->can('delete setting')) {
                    $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $row->id . '"
                        data-route="' . route('settings.delete', $row->id) . '"
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
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Create Setting'),
            'types' => [
                'text' => 'Text',
                'number' => 'Number',
                'file' => 'File',
                'select' => 'Select',
                'textarea' => 'Textarea',
                'code' => 'Code',
                'radio' => 'Radio',
                'checkbox' => 'Checkbox'
            ]
        ];
        return view('cms.settings.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,file,select,textarea,code,radio,checkbox',
            'value' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            DB::beginTransaction();

            if ($request->type == 'code') {
                $folderPath = resource_path('views/customs');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $path = $folderPath . '/' . $request->name . '.blade.php';

                file_put_contents($path, $request->value);

                $request->value = $path;
            }

            if ($request->type == 'file') {
                $folderPath = public_path('uploads/settings');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('value');
                $filename = $request->name . '.' . $file->getClientOriginalExtension();
                $path = $folderPath . '/' . $filename;
                $file->move($path, $filename);

                $request->value = $path;
            }

            $setting = Setting::create([
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
                'status' => $request->status
            ]);

            DB::commit();

            return redirect()
                ->route('settings.index')
                ->with('success', __('Setting created successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Clean up any created files if needed
            if ($request->type == 'code' && isset($path)) {
                @unlink($path);
            }
            if ($request->type == 'file' && isset($path)) {
                @unlink($path);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('Failed to create setting: ') . $e->getMessage());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
