<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Request $request){
        $tasks = Task::where('user_id',$request->user()->id)->get();
        return ['message' => $tasks];
    }

    public function update(Request $request){
        $task = Task::find($request->id);

        if(!$task){
            return ['message' => 'no task'];
        }

        if($task->user_id !== $request->user()->id){
            return ['message' => 'not your task'];
        }

        $task->title = $request->title;
        $task->detail = $request->detail;
        $task->location = $request->location;
        $task->date = $request->date;
        $task->partner = $request->partner;
        $task->save();

        return ['message' => $task];
    }

    public function delete(Request $request){
        $task = Task::find($request->id);
        if($task->user_id !== $request->user()->id){
            return ['message' => 'not your task'];
        }
        $task->delete();
        return ['message' =>  $request->all()];
    }

    public function create(Request $request){
        $task = new Task;
        $task->title = $request->title;
        $task->detail = $request->detail;
        $task->location = $request->location;
        $task->date = $request->date;
        $task->partner = $request->partner;
        $task->user_id = $request->user()->id;
        $task->save();
        return ['message' => $request->all()];
    }
}
