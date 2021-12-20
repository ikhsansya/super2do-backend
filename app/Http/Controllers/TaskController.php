<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::get();
        return $this->sendResponse($task, 'Semua Data Task');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        return $this->sendResponse($task, 'Detail Task');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set task
        $task = new Task();
        $this->setTask($task, $request->all());

        return $this->sendResponse($task, 'Task berhasil dibuat');
    }

    /**
     * Update the specified resource in storage.
     *
    * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Set task
        $task = Task::find($id);
        $this->setTask($task, $request->all());

        return $this->sendResponse($task, 'Task berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return $this->sendResponse($task, 'Task berhasil dihapus');
    }

    private function setTask($task, $data)
    {
        $task->title    = $data['title'];
        $task->date     = $data['date'];
        $task->time     = $data['time'];
        $task->status   = $data['status'] ?? 1;
        $task->save();
    }


    /**
     * Set Status task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function setStatus(Request $request, $id)
    {
        // Set status task
        $task = Task::find($id);
        $data = $request->all();
        $task->status = $data['status'];
        $task->save();

        return $this->sendResponse($task, 'Status task berhasil diupdate');
    }

    /**
     * Set All Task Completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function setCompleteAll(Request $request)
    {
        // Set complete All
        $tasks = Task::where('status', 1)->get();
        if(!empty($tasks)){
            foreach ($tasks as $task) {
                $task->status = 2;
                $task->save();
            }
        }

        return $this->sendResponse($tasks, 'Status task berhasil diupdate');
    }

    /**
     * Delete All Complete Task.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAllComplete(Request $request)
    {
        $tasks = Task::where('status', 2)->get();
        if(!empty($tasks)){
            foreach ($tasks as $task) {
                $task->delete();
            }
        }

        return $this->sendResponse($tasks, 'Task berhasil dihapus');
    }

    /**
     * Get Total
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotal()
    {
        $active_task = Task::where('status', 1)->count();
        $completed_task = Task::where('status', 2)->count();
        $data = [
            'active' => $active_task,
            'completed' => $completed_task
        ];

        return $this->sendResponse($data, 'Total Task');
    }
}
