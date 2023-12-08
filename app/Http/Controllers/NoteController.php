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
        if($request->filterDate != 0) {
            if($request->filterDate < 0){
                $date['finish'] = Carbon::tomorrow()->subMonth(abs($request->filterDate))->endOfMonth()->addDays(1);
            }else {
                $date['finish'] = Carbon::tomorrow()->addMonth($request->filterDate)->endOfMonth();
            }
        }else {
            $date['finish'] = Carbon::tomorrow();
        }
        
        if($request->daysOffset != 0) $date['finish'] = $date['finish']->subDays($request->daysOffset);
        
        $date['start'] = $date['finish']->copy()->subMonth(1);
        $daysCount = $date['start']->daysInMonth;

        $notes = Note::where('user', Auth::id())->orderBy('day', 'DESC');
        if(!$request->bookmated && !$request->hideEmpty) $notes->whereBetween('day', [$date['start']->copy()->subDays(1), $date['finish']->copy()->subDays(1)]);
        if($request->bookmated) $notes->where('bookmated', $request->bookmated);
        if($request->bookmated || $request->hideEmpty) $notes = $notes->skip($request->daysOffset);
        $notes = $notes->take($daysCount)->get()->toArray();
        $notes = array_reverse($notes);

        $days = [];

        if($request->bookmated || $request->hideEmpty){
            foreach($notes as $keyNote => $note){
                $days[$keyNote]['fulldate'] = $note['day'];
                $days[$i]['day'] = date_format($day,'d');
                $days[$i]['month'] = date_format($day,'F');
                $days[$i]['dayWeek'] = date_format($day,'D');
                $days[$keyNote]['text'] = $note['text'];
                $days[$keyNote]['theday'] = $note['theday'];
                $days[$keyNote]['bookmated'] = $note['bookmated'];
            }
        }
        else {
            for($i = 0; $i < $daysCount; $i++){
                if($i){
                    $day = $date['start']->addDays(1);
                }
                else {
                    $day = $date['start'];
                }
                $days[$i]['fulldate'] = date_format($day,'Y-m-d');
                $days[$i]['day'] = date_format($day,'d');
                $days[$i]['month'] = date_format($day,'F');
                $days[$i]['dayWeek'] = date_format($day,'D');
                $days[$i]['text'] = '';
                $days[$i]['theday'] = true;
                $days[$i]['bookmated'] = false;

                if($notes){
                    foreach($notes as &$note){
                        if($days[$i]['fulldate'] == $note['day']){
                            $days[$i]['text'] = $note['text'];
                            $days[$i]['theday'] = $note['theday'];
                            $days[$i]['bookmated'] = $note['bookmated'];

                            unset($note);
                            break;
                        }
                    }
                }
            }
            
            $date['start'] = $date['start']->subDays($daysCount - 1);
        }

        /*if($days){
            $lastKey = count($days) - 1;
            
            if($days[$lastKey]['fulldate'] == Carbon::today()->toDateString()){
               $days[$lastKey]['title'] = 'Today';
            }
        }*/

        return ['days' => $days, 'daysOffset' => $request->daysOffset + $daysCount];
    }
    public function createorupdate(Request $request)
    {
        if(strlen($request->text) > 0){
            return Note::updateOrCreate(
                [
                    'user' => Auth::id(), 
                    'day' => $request->fulldate
                ], 
                [
                    'text' => $request->text, 
                    'bookmated' => $request->bookmated, 
                    'theday' => $request->theday
                ]);
        }
        else {
            Note::where(['user' => Auth::id(), 'day' => $request->fulldate])->delete();
        }
    }
}
