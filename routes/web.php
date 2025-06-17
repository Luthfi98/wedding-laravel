<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Cms\BankController;
use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\RoleController;
use App\Http\Controllers\Cms\UserController;
use App\Http\Controllers\Cms\ClientController;
use App\Http\Controllers\Cms\LanguageController;
use App\Http\Controllers\Cms\TemplateController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\PermissionController;
use App\Http\Controllers\Cms\LogActivityController;

Route::get('/', function () {
    $client = \App\Models\Client::firstOrFail();
    $template = \App\Models\Template::firstOrFail();
    $dataCL = $client['data'];
    $dataLocation = $dataCL['locations'];
    $dataGroom = $dataCL['groom'];
    $dataBride = $dataCL['bride'];
    $dataGallery = $dataCL['gallery'];
    $dataBank = $dataCL['bank_accounts']; 
    $dataStory = $dataCL['stories'];  
    $dataOther = $dataCL['other']; 

    $now = Carbon::now();


    $collection = collect($dataLocation);

    // Cari tanggal terdekat (bisa sebelum atau sesudah)
    $closest = $collection->sortBy(function ($item) use ($now) {
        return abs($now->diffInSeconds(Carbon::parse($item['date']), false));
    })->first();

    $closest['date'] = Carbon::parse($closest['date'])->locale('id_ID')->format('l, j F Y');
    $closest['dateFormated'] = str_replace(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'], $closest['date']);
    $closest['dateFormated'] = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], $closest['date']);
    // $date = Carbon::parse($closest['date'])->locale('id_ID')->isoFormat('d F Y, l');
    // dd($dataBank);
    $data = [
        'title' => $client->name,
        'client' => $client,
        'template' => $template,
        'to' => 'HIMATEKINFO',
        'closest' => $closest,
        'groom' => $dataGroom,
        'bride' => $dataBride,
        'gallery' => $dataGallery,
        'bank' => $dataBank,
        'location' => $dataLocation,
        'story' => $dataStory,
        'other' => $dataOther
    ];
    return view('templates.'.$template->id)->with($data);
});


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('data', [RoleController::class, 'getData'])->name('roles.data');
        Route::get('create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('{id}', [RoleController::class, 'destroy'])->name('roles.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('data', [UserController::class, 'getData'])->name('users.data');
        Route::get('create', [UserController::class, 'create'])->name('users.create');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('{id}', [UserController::class, 'destroy'])->name('users.delete');
    });


    Route::prefix('menus')->group(function () {
        Route::get('sorting', [MenuController::class, 'sorting'])->name('menus.sorting');
        Route::post('update-order', [MenuController::class, 'updateOrder'])->name('menus.update-order');
        Route::get('/', [MenuController::class, 'index'])->name('menus.index');
        Route::get('data', [MenuController::class, 'getData'])->name('menus.data');
        Route::get('create', [MenuController::class, 'create'])->name('menus.create');
        Route::post('store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('edit/{id}', [MenuController::class, 'edit'])->name('menus.edit');
        Route::put('update/{id}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('delete/{id}', [MenuController::class, 'destroy'])->name('menus.delete');

    });

    
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('data', [PermissionController::class, 'getData'])->name('permissions.data');
        Route::get('create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.delete');

    });

    
    Route::prefix('languages')->group(function () {
        Route::get('/', [LanguageController::class, 'index'])->name('languages.index');
        Route::get('data', [LanguageController::class, 'getData'])->name('languages.data');
        Route::get('create', [LanguageController::class, 'create'])->name('languages.create');
        Route::post('store', [LanguageController::class, 'store'])->name('languages.store');
        Route::get('edit/{id}', [LanguageController::class, 'edit'])->name('languages.edit');
        Route::put('update/{id}', [LanguageController::class, 'update'])->name('languages.update');
        Route::delete('delete/{id}', [LanguageController::class, 'destroy'])->name('languages.delete');

    });


    Route::prefix('templates')->group(function () {
        Route::get('/', [TemplateController::class, 'index'])->name('templates.index');
        Route::get('data', [TemplateController::class, 'getData'])->name('templates.data');
        Route::get('create', [TemplateController::class, 'create'])->name('templates.create');
        Route::post('store', [TemplateController::class, 'store'])->name('templates.store');
        Route::get('edit/{id}', [TemplateController::class, 'edit'])->name('templates.edit');
        Route::put('update/{id}', [TemplateController::class, 'update'])->name('templates.update');
        Route::put('update-html/{id}', [TemplateController::class, 'updateHtml'])->name('templates.update.html');
        Route::put('update-css/{id}', [TemplateController::class, 'updateCss'])->name('templates.update.css');
        Route::put('update-js/{id}', [TemplateController::class, 'updateJs'])->name('templates.update.js');
        Route::put('update-php/{id}', [TemplateController::class, 'updatePhp'])->name('templates.update.php');
        Route::delete('delete/{id}', [TemplateController::class, 'destroy'])->name('templates.delete');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('data', [ClientController::class, 'getData'])->name('clients.data');
        Route::get('create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('store', [ClientController::class, 'store'])->name('clients.store');
        Route::get('edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('update/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('delete/{id}', [ClientController::class, 'destroy'])->name('clients.delete');
        Route::post('upload-image', [ClientController::class, 'uploadImage'])->name('clients.upload-image');
        Route::post('delete-image', [ClientController::class, 'deleteImage'])->name('clients.delete-image');
    });

    Route::prefix('banks')->group(function () {
        Route::get('/', [BankController::class, 'index'])->name('banks.index');
        Route::get('data', [BankController::class, 'getData'])->name('banks.data');
        Route::get('create', [BankController::class, 'create'])->name('banks.create');
        Route::post('store', [BankController::class, 'store'])->name('banks.store');
        Route::get('edit/{id}', [BankController::class, 'edit'])->name('banks.edit');
        Route::put('update/{id}', [BankController::class, 'update'])->name('banks.update');
        Route::delete('delete/{id}', [BankController::class, 'destroy'])->name('banks.delete');
    });

    Route::prefix('log-activity')->group(function () {
        Route::get('/', [LogActivityController::class, 'index'])->name('log-activity.index');
        Route::get('data', [LogActivityController::class, 'getData'])->name('log-activity.data');
        Route::get('{id}', [LogActivityController::class, 'show'])->name('log-activity.show');
    });
    
});

Route::get('/{any}', function ($any) {
    $client = \App\Models\Client::where('slug', $any)->firstOrFail();
    $dataCL = $client['data'];
    $dataLocation = $dataCL['locations'];
    $dataGroom = $dataCL['groom'];
    $dataBride = $dataCL['bride'];
    $dataGallery = $dataCL['gallery'];
    $dataBank = $dataCL['bank_accounts']; 
    $dataStory = $dataCL['stories'];  
    $dataOther = $dataCL['other']; 
    $templateId = $dataOther['template_id'];
    $template = \App\Models\Template::find($templateId);

    $now = Carbon::now();


    $collection = collect($dataLocation);

    // Cari tanggal terdekat (bisa sebelum atau sesudah)
    $closest = $collection->sortBy(function ($item) use ($now) {
        return abs($now->diffInSeconds(Carbon::parse($item['date']), false));
    })->first();

    $closest['date'] = Carbon::parse($closest['date'])->locale('id_ID')->format('l, j F Y');
    $closest['dateFormated'] = str_replace(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'], $closest['date']);
    $closest['dateFormated'] = str_replace(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], $closest['date']);
    // $date = Carbon::parse($closest['date'])->locale('id_ID')->isoFormat('d F Y, l');
    // dd($dataBank);
    $data = [
        'title' => $client->name,
        'client' => $client,
        'template' => $template,
        'to' => strtoupper(request()->to),
        'closest' => $closest,
        'groom' => $dataGroom,
        'bride' => $dataBride,
        'gallery' => $dataGallery,
        'bank' => $dataBank,
        'location' => $dataLocation,
        'story' => $dataStory,
        'other' => $dataOther
    ];
    return view('templates.'.$template->id)->with($data);
});