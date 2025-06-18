<?php

namespace App\Http\Controllers\Cms;

use App\Models\Bank;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BankController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view bank', only: ['index', 'data', 'show']),
            new Middleware('permission:create bank', only: ['create', 'store']),
            new Middleware('permission:update bank', only: ['edit', 'update']),
            new Middleware('permission:delete bank', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Banks')
        ];
        return view('cms.banks.index')->with($data);
    }

    /**
     * Get data for DataTables
     */
    public function getData(Request $request)
    {
        $query = Bank::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btns = [];
                if (auth()->user()->can('update bank')) {
                    $btns[] = '<li><a class="dropdown-item" href="' . route('banks.edit', $row->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                }
                if (auth()->user()->can('delete bank')) {
                    $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $row->id . '"
                        data-route="' . route('banks.delete', $row->id) . '"
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
            ->editColumn('status', function ($row) {
                return $row->status === 'active' 
                    ? '<span class="badge bg-success">' . __('Active') . '</span>'
                    : '<span class="badge bg-danger">' . __('Inactive') . '</span>';
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
            'title' => __('Add Bank')
        ];
        return view('cms.banks.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->only(['name', 'code', 'status']);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->code . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banks'), $imageName);
            $data['image'] = 'uploads/banks/' . $imageName;
        }

        $bank = Bank::create($data);

        LogActivity::insertData($data, $bank->getTable());


        return redirect()->route('banks.index')
            ->with('success', __('Bank created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bank = Bank::findOrFail($id);
        $data = [
            'title' => __('Bank Details'),
            'bank' => $bank
        ];
        return view('cms.banks.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bank = Bank::findOrFail($id);
        $data = [
            'title' => __('Edit Bank'),
            'bank' => $bank
        ];
        return view('cms.banks.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bank = Bank::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks,code,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->only(['name', 'code', 'status']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($request->hasFile('image')) {
                // Delete old image
                if ($bank->image && file_exists(public_path($bank->image))) {
                    unlink(public_path($bank->image));
                }

                $image = $request->file('image');
                $imageName = $request->code . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/banks'), $imageName);
                $data['image'] = 'uploads/banks/' . $imageName;
            }
        }

        $bank->update($data);

        LogActivity::insertData($data, $bank->getTable());


        return redirect()->route('banks.index')
            ->with('success', __('Bank updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bank = Bank::findOrFail($id);

        // Delete image if exists
        // if ($bank->image && file_exists(public_path($bank->image))) {
        //     unlink(public_path($bank->image));
        // }

        $bank->delete();
        LogActivity::insertData($bank->toArray(), $bank->getTable());


        return response()->json([
            'success' => true,
            'message' => __('Bank deleted successfully.')
        ]);
    }
}
