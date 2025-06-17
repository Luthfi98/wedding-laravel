<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LogActivityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view log activity', only: ['index']),
            new Middleware('permission:detail log activity', only: ['show']),
        ];
    }
    /**
     * Display a listing of the activity logs.
     */
    public function index()
    {
        $data = [
            'title' => __('Log Activity')
        ];
        return view('cms.logActivity.index')->with($data);
    }

    /**
     * Get the data for DataTables.
     */
    public function getData(Request $request)
    {
        $query = LogActivity::with('user');

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply method filter
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '-';
            })
            ->addColumn('created_at_formatted', function ($row) {
                return $row->created_at->format('d M Y H:i:s');
            })
            ->addColumn('action', function ($row) {
                $btns = [];
                if (auth()->user()->can('detail log activity')) {
                    $btns[] = '<li><a class="dropdown-item" href="' . route('log-activity.show', $row->id) . '"><i class="bi bi-eye"></i> Detail</a></li>';
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
    }

    /**
     * Display the specified activity log.
     */
    public function show($id)
    {
        $logActivity = LogActivity::with('user')->findOrFail($id);

        $data = [
            'title' => __('Detail Log Activity'),
            'log' => $logActivity
        ];
        
        return view('cms.logActivity.show', $data);
    }
} 