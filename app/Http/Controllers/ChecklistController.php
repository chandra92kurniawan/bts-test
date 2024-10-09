<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;

class ChecklistController extends Controller
{
    //
    public function list(){
        $user_id=$GLOBALS['user_id'];
        $checklist=Checklist::with(['items','items.detail'])->where('user_id',$user_id)->get();
        return response()->json([
            'message' => '',
            'data'=>$checklist
        ], 200);
    }
    public function create(Request $request){

        $add=new Checklist();
        $add->user_id=$GLOBALS['user_id'];
        $add->name=$request->name;
        $add->save();
        return response()->json([
            'message' => '',
            'data'=>$add
        ], 201);
    }
    public function delete($id){
        $user_id=$GLOBALS['user_id'];
        $checklist=Checklist::where('user_id',$user_id)->where('id',$id)->first();
        if($checklist){
            $checklist->delete();
            $message="berhasil menghapus";
            $code=201;
            $data=null;
        }else{
            $message="Data tidak ditemukan";
            $code=404;
            $data=null;
        }
        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);
    }
}
