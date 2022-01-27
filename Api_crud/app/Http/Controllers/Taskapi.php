<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskResource;
class Taskapi extends Controller
{
    public function index(){
        $data=Task::all();
        return response(['tasks'=>new TaskResource($data)]);
    }
    public function store(Request $req){
        $validator=Validator::make($req->all(),[
            'name'=>'required',
            'description'=>'max:500'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }else{
            $data=new Task();
            $data->name=$req->name;
            $data->description=$req->description;
            if($data->save()){

                return response(['msg'=>'api added','tasks'=>new TaskResource($data)]);
            }else{
                return response()->json(['msg'=>'api not added']);
            }
        }

    }
    public function update(Request $req)
    {   $data=Task::find($req->id);
        $data->name=$req->name;
        $data->description=$req->description;
        if($data->save())
        return response()->json(['msg'=>'updated']);
        else
        return response()->json(['msg'=>'not updated']);
    }
    public function show($id)
    {
        $data=Task::find($id);
        return response(['tasks'=>new TaskResource($data)]);
    }
    public function destroy($id)
    { $data=Task::destroy($id);
        return response()->json("destroy");
    }
}
