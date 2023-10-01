<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskPriorityUpdateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\ProjectCollection;
use App\Models\Priorities;
use App\Models\Project;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = new ProjectCollection(Project::with('tasks')->get());
        return Inertia::render('Home', ['projects' => $projects->collection, 'priorities' => Priorities::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request, Tasks $tasks)
    {
        $tasks->create($request->validated());
        return redirect('/')->with('success', 'Task added successfully!');

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
    public function update(Tasks $id, TaskUpdateRequest $request)
    {
        $id->updateOrFail($request->validated());
        return redirect('/')->with('success', 'Task updated!');
    }

    public function updatePriority(Tasks $id, TaskPriorityUpdateRequest $request)
    {
        $id->updateOrFail($request->validated());
        return redirect('/')->with('success', 'Task Priority updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $id)
    {
        $id->deleteOrFail();
        return redirect('/')->with('success', 'Task Deleted!');
    }
}