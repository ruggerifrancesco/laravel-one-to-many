<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DEBUG RUN (DEV ONLY) -> Uncomment this for testing
        // dd($request->all());
        // die;

        $dataProject = $request->validate([
            'title' => ['required', 'unique:projects','min:5', 'max:255'],
            'goals' => ['required', 'array', 'min:1'],
            'budget' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:99999999.99'],
            'image' => ['required', 'image', 'max:1024'],
            'nPartecipants' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'min:30'],
        ]);

        $dataProject['goals'] = json_encode($dataProject['goals']);

        if ($request->hasFile('image')) {
            $img_path = Storage::put('uploads/project-image/', $request->file('image'));
            $dataProject['image'] = $img_path;
        }

        $newProject = Project::create($dataProject);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // DEBUG RUN (DEV ONLY) -> Uncomment this for testing
        // dd($request->all());
        // die;

        $project = Project::findOrFail($id);

        $dataProject = $request->validate([
            'title' => ['required','min:5', 'max:255', Rule::unique('projects')->ignore($project->id)],
            'goals' => ['required', 'array', 'min:1'],
            'budget' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:99999999.99'],
            'status' => ['nullable', 'boolean', 'in:0,1'],
            // The validation image not required for input pass form, because it has alredy the value in it
            'image' => ['image', 'max:1024'],
            'nPartecipants' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'min:30'],
        ]);

        if ($request->hasFile('image')) {
            $img_path = Storage::put('uploads/project-image/', $request->file('image'));
            $dataProject['image'] = $img_path;
        } elseif ($request->has('image')) {
            // Keep the existing image value if no new image is uploaded
            $dataProject['image'] = $request->input('image');
        }

        $project->update($dataProject);

        return redirect()->route('admin.projects.index', compact('project'))->with('success', 'Project edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display a listing of the deleted resources.
     */
    public function deletedIndex()
    {
        $projects = Project::onlyTrashed()->paginate(10);

        return view('admin.projects.deleted', compact('projects'));
    }

    /**
     * Restoring the specified resource from deleted storage.
     */
    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('admin.projects.index', $project)->with('success', 'Project restored successfully');
    }

    /**
     * Delete permantently the specified resource from storage.
     */

    public function obliterate(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}
