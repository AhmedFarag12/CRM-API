<?php

namespace App\Http\Controllers;

use Crm\Customer\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotesController extends Controller
{
    public function index($customerId){
        return Note::where('customer_id', $customerId)->get();
    }

    public function show($id){

        return Note::find($id) ?? response()->json(['status'=>'Not Found!'], Response::HTTP_NOT_FOUND);

    }

    public function create(Request $request, $customerId){
        $note = new Note();
        $note->note = $request->note;
        $note->customer_id = $customerId;
        $note->save();
        return $note;
    }

    public function update(Request $request , $id, $customerId){
        $note =  Note::find($id);

        if(! $note){
            return response()->json(['status'=>'Not Found!'], Response::HTTP_NOT_FOUND);
        }

        $customerId = (int)$customerId;
        if($note->customer_id !== $customerId){
            return response()->json(['status'=>'Invalid Data!'], Response::HTTP_BAD_REQUEST);
        }

        $note->note = $request->note;
        $note->save();
        return $note;
    }


    public function delete(Request $request ,$customerId, $id){
        $note =  Note::find($id);

        if(! $note){
            return response()->json(['status'=>'Not Found!'], Response::HTTP_NOT_FOUND);
        }

        $customerId = (int)$customerId;
        if($note->customer_id !== $customerId){
            return response()->json(['status'=>'Invalid Data!'], Response::HTTP_BAD_REQUEST);
        }
        $note->delete();
        return response()->json(['status'=>'Deleted!'],Response::HTTP_OK);
    }

}
