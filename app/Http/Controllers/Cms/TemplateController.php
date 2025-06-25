<?php

namespace App\Http\Controllers\Cms;

use App\Models\Template;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use MatthiasMullie\Minify;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TemplateController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view template', only: ['index', 'getData', 'show']),
            new Middleware('permission:create template', only: ['create', 'store']),
            new Middleware('permission:update template', only: ['edit', 'update']),
            new Middleware('permission:delete template', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => __('Templates')
        ];

        return view('cms.templates.index')->with($data);
    }

    /**
     * Get templates data for DataTables
     */
    public function getData(Request $request)
    {
        if($request->ajax()) {
            $templates = Template::with('createdBy');
            
            if ($request->status != null) {
                $templates->where('status', $request->status);
            }

            return DataTables::of($templates)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($template) {
                    return $template->id;
                })
                ->editColumn('status', function ($template) {
                    $badge = $template->status == 'active' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $badge . '">' . ucfirst($template->status) . '</span>';
                })
                ->addColumn('action', function ($template) {
                    $btns = [];
                    
                    if (auth()->user()->can('update template')) {
                        $btns[] = '<li><a class="dropdown-item" href="' . route('templates.edit', $template->id) . '"><i class="bi bi-pencil"></i> Edit</a></li>';
                    }
                    
                    if (auth()->user()->can('delete template')) {
                        $btns[] = '<li><button type="button" class="dropdown-item text-danger" 
                            data-id="' . $template->id . '"
                            data-route="' . route('templates.delete', $template->id) . '"
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
            'title' => __('Add Template')
        ];
        return view('cms.templates.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_file' => 'nullable|file|mimes:html,htm|max:2048',
            // 'css_file' => 'nullable|file|mimes:css|max:2048',
            // 'js_file' => 'nullable|file|mimes:js|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        // Create template first to get the ID
        $template = new Template();
        $template->name = $request->name;
        $template->description = $request->description;
        $template->status = $request->status;
        $template->created_by = auth()->id();
        $template->save();

        // Create directory for template files
        $templatePath = public_path('assets/templates/' . $template->id);
        if (!file_exists($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $fileContent = [];

        if ($request->hasFile('html_file')) {
            $htmlFile = $request->file('html_file');
            $htmlFileName = 'template.html';
            $htmlFile->move($templatePath, $htmlFileName);
            $fileContent['html'] = 'assets/templates/' . $template->id . '/' . $htmlFileName;
        }

        if ($request->hasFile('css_file')) {
            $cssFile = $request->file('css_file');
            $cssFileName = 'style.css';
            $cssFile->move($templatePath, $cssFileName);
            $fileContent['css'] = 'assets/templates/' . $template->id . '/' . $cssFileName;
        }

        if ($request->hasFile('js_file')) {
            $jsFile = $request->file('js_file');
            $jsFileName = 'script.js';
            $jsFile->move($templatePath, $jsFileName);
            $fileContent['js'] = 'assets/templates/' . $template->id . '/' . $jsFileName;
        }

        // Update template with file paths
        $template->file_content = $fileContent;
        $template->save();

        LogActivity::insertData($template->toArray(), $template->getTable());


        return redirect()->route('templates.index')->with('success', __('Template created successfully'));
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
        $template = Template::findOrFail($id);
        
        $data = [
            'title' => __('Edit Template'),
            'template' => $template,
            'htmlContent' => '',
            'cssContent' => '',
            'jsContent' => ''
        ];

        // Load file contents if they exist
        if (!empty($template->file_content)) {
            if (isset($template->file_content['html'])) {
                $htmlPath = public_path($template->file_content['html']);
                if (file_exists($htmlPath)) {
                    $data['htmlContent'] = file_get_contents($htmlPath);
                }
            }
            
            if (isset($template->file_content['css'])) {
                $cssPath = public_path($template->file_content['css']);
                if (file_exists($cssPath)) {
                    $data['cssContent'] = file_get_contents($cssPath);
                }
            }
            
            if (isset($template->file_content['js'])) {
                $jsPath = public_path($template->file_content['js']);
                if (file_exists($jsPath)) {
                    $data['jsContent'] = file_get_contents($jsPath);
                }
            }

            if (isset($template->file_content['php'])) {
                $phpPath = resource_path($template->file_content['php']);
                if (file_exists($phpPath)) {
                    $data['phpContent'] = file_get_contents($phpPath);
                }
            }


        }


        return view('cms.templates.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $template = Template::findOrFail($id);
        $template->name = $request->name;
        $template->description = $request->description;
        $template->status = $request->status;
        $template->save();

        LogActivity::insertData($template->toArray(), $template->getTable());

        return response()->json([
            'success' => true,
            'message' => __('Template updated successfully')
        ]);
    }

    /**
     * Update HTML content
     */
    public function updateHtml(Request $request, string $id)
    {
        $request->validate([
            'html_content' => 'required|string'
        ]);

        $template = Template::findOrFail($id);
        $templatePath = public_path('assets/templates/' . $template->id);
        
        if (!file_exists($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $htmlPath = $templatePath . '/template.html';
        // dd($htmlPath, $request->html_content);
        file_put_contents($htmlPath, $request->html_content);

        $fileContent = $template->file_content ?? [];
        $fileContent['html'] = 'assets/templates/' . $template->id . '/template.html';
        $template->file_content = $fileContent;
        $template->save();

        LogActivity::insertData($fileContent, $template->getTable());

        return response()->json([
            'success' => true,
            'message' => __('HTML content updated successfully')
        ]);
    }

    /**
     * Update CSS content
     */
    public function updateCss(Request $request, string $id)
    {
        $request->validate([
            'css_content' => 'required|string'
        ]);

        $template = Template::findOrFail($id);
        $templatePath = public_path('assets/templates/' . $template->id);
        
        if (!file_exists($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $cssPath = $templatePath . '/style';
        // $minifiedCss = Minify::minify($request->css_content);

        $minifier = new Minify\CSS();
        $minifier->add($request->css_content);
        $minifiedCss = $minifier->minify();


        file_put_contents($cssPath.'-min.css', $minifiedCss);
        file_put_contents($cssPath.'.css', $request->css_content);

        $fileContent = $template->file_content ?? [];
        $fileContent['css'] = 'assets/templates/' . $template->id . '/style.css';
        $template->file_content = $fileContent;
        $template->save();
        LogActivity::insertData($fileContent, $template->getTable());


        return response()->json([
            'success' => true,
            'message' => __('CSS content updated successfully')
        ]);
    }

    /**
     * Update JavaScript content
     */
    public function updateJs(Request $request, string $id)
    {
        $request->validate([
            'js_content' => 'required|string'
        ]);

        $template = Template::findOrFail($id);
        $templatePath = public_path('assets/templates/' . $template->id);
        
        if (!file_exists($templatePath)) {
            mkdir($templatePath, 0755, true);
        }

        $jsPath = $templatePath . '/script';

        $minifier = new Minify\JS();
        $minifier->add($request->js_content);
        $minifiedjs = $minifier->minify();


        file_put_contents($jsPath.'-min.js', $minifiedjs);
        file_put_contents($jsPath.'.js', $request->js_content);
        
        
        
        file_put_contents($jsPath, $request->js_content);

        $fileContent = $template->file_content ?? [];
        $fileContent['js'] = 'assets/templates/' . $template->id . '/script.js';
        $template->file_content = $fileContent;
        $template->save();
        LogActivity::insertData($fileContent, $template->getTable());


        return response()->json([
            'success' => true,
            'message' => __('JavaScript content updated successfully')
        ]);
    }
    
    public function updatePhp(Request $request, string $id)
    {
        $request->validate([
            'php_content' => 'required|string'
        ]);
        
        $template = Template::findOrFail($id);
        $templatePath = resource_path('views/templates/' . $id . '.blade.php');
        
        // if (!dirname($templatePath)) {
        //     mkdir(dirname($templatePath), 0755, true);
        // }
        file_put_contents($templatePath, $request->php_content);


        $fileContent = $template->file_content ?? [];
        $fileContent['php'] = 'views/templates/' . $id . '.blade.php';
        $template->file_content = $fileContent;
        $template->save();
        LogActivity::insertData($fileContent, $template->getTable());


        return response()->json([
            'success' => true,
            'message' => __('PHP content updated successfully')
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = Template::findOrFail($id);
        
        // Delete template files
        $templatePath = public_path('assets/templates/' . $template->id);
        if (file_exists($templatePath)) {
            $files = glob($templatePath . '/*');
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir($templatePath);
        }

        $template->delete();
        LogActivity::insertData($template->toArray(), $template->getTable());

        return response()->json(['success' => true, 'message' => __('Template deleted successfully')]);
    }
}
