<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(Request $request){
        $notes = Note::where('user', Auth::id())->orderBy('fulldate', 'ASC')->get()->toArray();

        return response()->json($notes, 200);
    }
    public function createorupdate(Request $request){
        $textOnlyWithBr = strip_tags($request->text, '<br><u><b><i>');
        $textWithoutTags = strip_tags($textOnlyWithBr);

        if(strlen($textWithoutTags) > 0){
            return Note::updateOrCreate(
                [
                    'user' => Auth::id(), 
                    'fulldate' => $request->fulldate
                ], 
                [
                    'text' => $textOnlyWithBr, 
                    'bookmated' => $request->bookmated, 
                    'theday' => $request->theday
                ]);
        }
        else {
            Note::where(['user' => Auth::id(), 'fulldate' => $request->fulldate])->delete();
        }
    }
    public function updateBookmated(Request $request){
        Note::where(['id' => $request->noteId, 'user' => Auth::id()])->update(['bookmated' => $request->bookmated]);
    }
}
