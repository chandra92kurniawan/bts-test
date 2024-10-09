<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Checklist;

class ItemController extends Controller
{
    //
    
    public function list($checklistId){
        $user_id=$GLOBALS['user_id'];
        $item=Item::with(['detail','checklist'])->whereHas('checklist', function ($query) use($user_id) {
            // Tambahkan kondisi untuk checklist yang ingin dicari
            $query->where('user_id', $user_id); // Misalnya, hanya ambil checklist yang sudah selesai
        })->where('parent_id',null)->where('checklist_id',$checklistId)->get();
        return response()->json([
            'message' => '',
            'data'=>$item
        ], 200);
    }
    public function listItem($checklistId,$itemId){
        $user_id=$GLOBALS['user_id'];
        $item=Item::with(['detail','checklist'])->whereHas('checklist', function ($query) use($user_id) {
            // Tambahkan kondisi untuk checklist yang ingin dicari
            $query->where('user_id', $user_id); // Misalnya, hanya ambil checklist yang sudah selesai
        })->where('parent_id',null)->where('checklist_id',$checklistId)->where('id',$itemId)->get();
        return response()->json([
            'message' => '',
            'data'=>$item
        ], 200);
    }
    public function createItem(Request $request,$checklistId){
        $user_id=$GLOBALS['user_id'];
        $check=Checklist::where('id',$checklistId)->where('user_id',$user_id)->first();
        if($check){
            $add=new Item();
            $add->item=$request->itemName;
            $add->status=0;
            $add->checklist_id=$checklistId;
            $add->save();
            $message="berhasil buat item";
            $code=201;
            $data=$add;
        }else{
            $message="gagal buat item";
            $code=400;
            $data=null;
        }
        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);
    }

    public function updateStatus(Request $request,$checklistId,$itemId){
        $status=$request->status;
        $user_id=$GLOBALS['user_id'];
        $check=Checklist::where('id',$checklistId)->where('user_id',$user_id)->first();
        if($check){
            if($status!=null and in_array($status,[0,1])){
                $edit=Item::where('id',$itemId)->first();
                if($edit){
                    $edit->status=$status;
                    $edit->save();
                    $message="berhasil ubah item status";
                    $code=201;
                    $data=$edit;
                }else{
                    $message="Item tidak ditemukan";
                    $code=400;
                    $data=null;
                }
            }else{
                $message="Item status tidak diijinkan";
                $code=400;
                $data=null;
            }
            
        }else{
            $message="gagal ubah item status";
            $code=400;
            $data=null;
        }
        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);
    }

    public function renameItem(Request $request,$checklistId,$itemId){
        $itemName=$request->itemName;
        $user_id=$GLOBALS['user_id'];
        $check=Checklist::where('id',$checklistId)->where('user_id',$user_id)->first();
        if($check){
            $edit=Item::where('id',$itemId)->first();
            if($edit){
                $edit->item=$itemName;
                $edit->save();
                $message="berhasil rename item";
                $code=201;
                $data=$edit;
            }else{
                $message="Item tidak ditemukan";
                $code=400;
                $data=null;
            }
            
        }else{
            $message="gagal rename item";
            $code=400;
            $data=null;
        }
        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);
    }

    public function deleteItem($checklistId,$itemId){
        $user_id=$GLOBALS['user_id'];
        $check=Checklist::where('id',$checklistId)->where('user_id',$user_id)->first();
        if($check){
            $exist=Item::where('id',$itemId)->first();
            if($exist){
                $exist->delete();
                $message="berhasil hapus item";
                $code=201;
                $data=null;
            }else{
                $message="Item tidak ditemukan";
                $code=400;
                $data=null;
            }
            
        }else{
            $message="gagal hapus item";
            $code=400;
            $data=null;
        }
        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);
    }
}
