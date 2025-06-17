<?php

namespace App\Http\Controllers\Cms;

use App\Models\Bank;
use App\Models\Client;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
// use Intervention\Image\Facades\Image;

class ClientController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view client', only: ['index', 'data', 'show']),
            new Middleware('permission:create client', only: ['create', 'store']),
            new Middleware('permission:update client', only: ['edit', 'update']),
            new Middleware('permission:delete client', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Clients')
        ];

        return view('cms.clients.index')->with($data);
    }

    /**
     * Get clients data for DataTables
     */
    public function getData(Request $request)
    {
        if($request->ajax()) {
            $clients = Client::with('createdBy');
            
            if ($request->status !== null) {
                $clients->where('status', $request->status);
            }

            return DataTables::of($clients)
                ->addIndexColumn()
                ->addColumn('action', function ($client) {
                    $btns = [];
                    
                    if (auth()->user()->can('update client')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('clients.edit', $client->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    
                    if (auth()->user()->can('delete client')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                        data-id="' . $client->id . '"
                        data-route="'.route('clients.delete', $client->id).'"
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
                ->editColumn('status', function ($client) {
                    $badge = $client->status ? 'success' : 'danger';
                    $status = $client->status ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $badge . '">' . $status . '</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => __('Add Client')
        ];
        return view('cms.clients.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'slug' => 'nullable|string|max:255|unique:clients,slug',
            'status' => 'required|boolean',
            'data.groom.name' => 'nullable|string|max:255',
            'data.groom.father' => 'nullable|string|max:255',
            'data.groom.mother' => 'nullable|string|max:255',
            'data.groom.birth_order' => 'nullable|integer|min:1',
            'data.groom.total_siblings' => 'nullable|integer|min:1',
            'data.groom.instagram' => 'nullable|string|max:255',
            'data.bride.name' => 'nullable|string|max:255',
            'data.bride.father' => 'nullable|string|max:255',
            'data.bride.mother' => 'nullable|string|max:255',
            'data.bride.birth_order' => 'nullable|integer|min:1',
            'data.bride.total_siblings' => 'nullable|integer|min:1',
            'data.bride.instagram' => 'nullable|string|max:255',
            'data.locations.*.name' => 'required|string|max:255',
            'data.locations.*.date' => 'required|date',
            'data.locations.*.location' => 'required|string',
            'data.locations.*.maps' => 'nullable|url',
            'data.gallery.*' => 'nullable|url',
            'data.bank.name' => 'nullable|string|max:255',
            'data.bank.account' => 'nullable|string|max:255',
            'data.bank.holder' => 'nullable|string|max:255',
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->slug = $request->slug ?? Str::slug($request->name);
        $client->status = $request->status;
        $client->created_by = auth()->id();

        // Process data
        $data = [];
        
        // Couple data
        if ($request->has('data.groom')) {
            $data['groom'] = [
                'name' => $request->input('data.groom.name'),
                'father' => $request->input('data.groom.father'),
                'mother' => $request->input('data.groom.mother'),
                'birth_order' => $request->input('data.groom.birth_order'),
                'total_siblings' => $request->input('data.groom.total_siblings'),
                'instagram' => $request->input('data.groom.instagram'),
            ];
        }
        
        if ($request->has('data.bride')) {
            $data['bride'] = [
                'name' => $request->input('data.bride.name'),
                'father' => $request->input('data.bride.father'),
                'mother' => $request->input('data.bride.mother'),
                'birth_order' => $request->input('data.bride.birth_order'),
                'total_siblings' => $request->input('data.bride.total_siblings'),
                'instagram' => $request->input('data.bride.instagram'),
            ];
        }

        // Locations
        if ($request->has('data.locations')) {
            $data['locations'] = [];
            foreach ($request->input('data.locations') as $location) {
                if (!empty($location['name']) && !empty($location['date']) && !empty($location['location'])) {
                    $data['locations'][] = [
                        'name' => $location['name'],
                        'date' => $location['date'],
                        'location' => $location['location'],
                        'maps' => $location['maps'] ?? null,
                    ];
                }
            }
        }

        // Gallery
        if ($request->has('data.gallery')) {
            $data['gallery'] = $request->input('data.gallery');
        }

        // Bank data
        if ($request->has('data.bank')) {
            $data['bank'] = [
                'name' => $request->input('data.bank.name'),
                'account' => $request->input('data.bank.account'),
                'holder' => $request->input('data.bank.holder'),
            ];
        }

        $client->data = $data;
        $client->save();

        return redirect()->route('clients.index')->with('success', __('Client created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        $templates = Template::where('status', 'active')->get();
        // dd($client);
        $data = [
            'title' => __('Edit Client'),
            'client' => $client,
            'banks' => Bank::all(),
            'templates' => $templates
        ];

        return view('cms.clients.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $activeTab = $request->input('active_tab');

        // dd($request->all());
        // dd($activeTab);
        $rules = [];
        switch ($activeTab) {
            case 'basic':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:clients,email,' . $id,
                    'phone' => 'nullable|string|max:20',
                    'slug' => 'nullable|string|max:255|unique:clients,slug,' . $id,
                    'status' => 'required|boolean',
                ];
                break;
            case 'couple':
                $rules = [
                    'data.groom.name' => 'nullable|string|max:255',
                    'data.groom.father' => 'nullable|string|max:255',
                    'data.groom.mother' => 'nullable|string|max:255',
                    'data.groom.birth_order' => 'nullable|integer|min:1',
                    'data.groom.total_siblings' => 'nullable|integer|min:1',
                    'data.groom.instagram' => 'nullable|string|max:255',
                    'data.bride.name' => 'nullable|string|max:255',
                    'data.bride.father' => 'nullable|string|max:255',
                    'data.bride.mother' => 'nullable|string|max:255',
                    'data.bride.birth_order' => 'nullable|integer|min:1',
                    'data.bride.total_siblings' => 'nullable|integer|min:1',
                    'data.bride.instagram' => 'nullable|string|max:255',
                ];
                break;
            case 'locations':
                $rules = [
                    'data.locations.*.name' => 'required|string|max:255',
                    'data.locations.*.date' => 'required|date',
                    'data.locations.*.location' => 'required|string|max:255',
                    'data.locations.*.address' => 'required|string|max:255',
                    'data.locations.*.maps' => 'nullable|url',
                ];
                break;
            case 'story':
                $rules = [
                    'data.story.*.date' => 'required|date',
                    'data.story.*.title' => 'required|string|max:255',
                    'data.story.*.description' => 'required|string'
                ];
                break;
            case 'gallery':
                $rules = [
                    'data.gallery.*' => 'nullable',
                ];
                break;
            case 'bank':
                $rules = [
                    'data.bank.*.bank_name' => 'nullable|string|max:255',
                    'data.bank.*.account_number' => 'nullable|string|max:255',
                    'data.bank.*.account_holder' => 'nullable|string|max:255',
                ];
                break;
            case 'other':
                $rules = [
                    'data.other.background' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    'data.other.file_song' => 'nullable|mimetypes:audio/mpeg,mpga,mp3,wav,aac',
                    'data.other.template_id' => 'required|exists:templates,id',
                ];
                break;
            default:
                $rules = [];
                break;
        }

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors())->with('active_tab', $activeTab);
        }

        // dd($request->validate($rules));

        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->slug = $request->slug ?? Str::slug($request->name);
        $client->status = $request->status;

        // Process data
        $data = $client->data ?? [];
        
        // Couple data
        if ($request->has('data.groom')) {
            $data['groom'] = [
                'name' => $request->input('data.groom.name'),
                'nickname' => $request->input('data.groom.nickname'),
                'father' => $request->input('data.groom.father'),
                'mother' => $request->input('data.groom.mother'),
                'birth_order' => $request->input('data.groom.birth_order'),
                'total_siblings' => $request->input('data.groom.total_siblings'),
                'instagram' => $request->input('data.groom.instagram'),
            ];
        }
        
        if ($request->has('data.bride')) {
            $data['bride'] = [
                'name' => $request->input('data.bride.name'),
                'nickname' => $request->input('data.bride.nickname'),
                'father' => $request->input('data.bride.father'),
                'mother' => $request->input('data.bride.mother'),
                'birth_order' => $request->input('data.bride.birth_order'),
                'total_siblings' => $request->input('data.bride.total_siblings'),
                'instagram' => $request->input('data.bride.instagram'),
            ];
        }

        // Locations
        if ($request->has('data.locations')) {
            $data['locations'] = [];
            foreach ($request->input('data.locations') as $location) {
                if (!empty($location['name']) && !empty($location['date']) && !empty($location['location'])) {
                    $data['locations'][] = [
                        'name' => $location['name'],
                        'date' => $location['date'],
                        'location' => $location['location'],
                        'address' => $location['address'] ?? null,
                        'maps' => $location['maps'] ?? null,
                    ];
                }
            }
        }
        $data['stories'] = [];
        if ($request->has('data.stories')) {
            foreach ($request->input('data.stories') as $story) {
                // dd($story);
                if (!empty($story['title']) && !empty($story['date']) && !empty($story['description'])) {
                    $data['stories'][] = [
                        'title' => $story['title'],
                        'date' => $story['date'],
                        'description' => $story['description'] ?? null,
                    ];
                }
            }
        }


        // Gallery
        $data['gallery'] = [];
        if ($request->has('data.gallery')) {
            foreach ($request->input('data.gallery') as $image) {
                if (!empty($image)) {
                    $data['gallery'][] = $image;
                }
            }
        }
        // dd($data);

        // Bank data
        if ($request->has('data.bank_accounts')) {
            $bankAccounts = $request->input('data.bank_accounts');
            $bankCodes = array_unique(array_column($bankAccounts, 'bank_name'));
            $banks = Bank::whereIn('code', $bankCodes)->get()->keyBy('code');
            // dd($banks, $bankAccounts);
            $data['bank_accounts'] = [];
            foreach ($bankAccounts as $account) {
                if (!empty($account['bank_name']) && !empty($account['account_number']) && !empty($account['account_holder'])) {
                    $bank = $banks->get($account['bank_name']);
                    if ($bank) {
                        $data['bank_accounts'][] = [
                            'bank_fullname' => $bank->name,
                            'bank_logo' => $bank->image,
                            'bank_name' => $account['bank_name'],
                            'account_number' => $account['account_number'],
                            'account_holder' => $account['account_holder'],
                        ];
                    }
                }
            }
        }

        // Background image
        if ($request->hasFile('data.other.background')) {
            $directory = "assets/invitation/{$client->id}/gallery/";
            $background = $request->file('data.other.background');
            $backgroundName = 'background_' . time() . '.' . $background->getClientOriginalExtension();
            $background->move(public_path($directory), $backgroundName);
            $data['other']['background'] = $directory . $backgroundName;
        }

        if ($request->hasFile('data.other.file_song')) {
            $directory = "assets/invitation/{$client->id}/song/";
            $file_song = $request->file('data.other.file_song');
            $file_songName = 'file_song_' . time() . '.' . $file_song->getClientOriginalExtension();
            $file_song->move(public_path($directory), $file_songName);
            $data['other']['file_song'] = $directory . $file_songName;
        }

        $data['other']['template_id'] = $request->input('data.other.template_id');


        // dd($data);

        $client->data = $data;
        $client->save();

        return redirect()->route('clients.edit', $client->id)->with('success', __('Client updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => __('Client deleted successfully')
        ]);
    }

    /**
     * Upload gallery image
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                // 'image' => 'required|array',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB max
            ]);

            $image = $request->file('image');
            // dd($image);
            $clientId = $request->client_id;
            
            // Create directory if it doesn't exist
            $directory = "assets/invitation/{$clientId}/gallery/";
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $image->move($directory, $filename);
            // dd($filename);
            $filenames[] = $filename;

            return response()->json([
                'success' => true,
                'url' => asset($directory . $filename),
                'filename' => $directory.$filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete gallery image
     */
    public function deleteImage(Request $request)
    {
        try {
            $request->validate([
                'image_url' => 'required|string'
            ]);

            $imageUrl = $request->image_url;
            $path = str_replace(asset('storage/'), '', $imageUrl);
            
            // Delete from storage
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
