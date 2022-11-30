<?php

namespace App\Http\Controllers;

use App\Models\todoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    //GET
    public function index()
    {
        try {
            $toDoLists = todoList::all();
            return response()->json($toDoLists, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage(),500);
        }
    }

    //CREATE
    public function store(Request $request)
    {
        try {
            todoList::create($request->all());
            return response()->json('To Do List created successifully', 201);
        } catch (\Exception $error) {
            return response()->json($error->getMessage(),500);

        }
    }
   
    //UPDATE
    public function update(Request $request, int $id)
    {
        try {
            $toDoList = todoList::find($id);
            $toDoList->update($request->all());
            return response()->json('To Do List updated successifully', 201);
        } catch (\Exception $error) {
            return response()->json($error->getMessage(),500);

        }
    }

   
    public function destroy($id)
    {
        try {
            $toDoList = todoList::find($id);
            $toDoList->delete();
            return response()->json('To Do List deleted successifully', 201);

        } catch (\Exception $error) {
            return response()->json($error->getMessage(),500);

        }
    }
}
