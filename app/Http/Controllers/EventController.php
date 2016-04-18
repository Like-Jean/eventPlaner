<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        dd($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_event(Request $request)
    {
        //Get the user who wants to create the event
        $account_id = $request->input('account_id');
        $user = Account::find($account_id);
   
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:16',
            'place' => 'required|max:10',
            'beginTime' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        //get all the arguements of an event
        $name = $request->input('name');
        $place = $request->input('place');
        $beginTime = $request->input('beginTime');
        $type = $request->input('type','');
        $description = $request->input('description','');

        $event = new Event;
        $event->name = $name;
        $event->place = $place;
        $event->type = $type;
        $event->description = $description;
        $event->beginTime = $beginTime;
        $event->host()->associate($user);

        $event->save();

        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>$event->id]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_myEvents(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'p' => 'required',
            'account_id' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $p = (int)$request->input('p');
        $account_id = $request->input('account_id');

        $events = DB::table('events')->select('name','place','beginTime','type','created_at','updated_at','isCanceled')->where('host_id','=',$account_id)->skip($p)->take(6)->get();

        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>$events]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function event_list(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'p' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $p = (int)$request->input('p');

        $p = $p*6;
        $events = DB::table('events')->select('name','place','beginTime','type','created_at')->where('isCanceled','=',0)->skip($p)->take(6)->get();

        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>$events]);
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_event(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'event_id' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $id = $request->input('event_id');
        $event = Event::find($id);

        $place = $request->input('place');
        $beginTime = $request->input('beginTime');
        $type = $request->input('type','');
        $description = $request->input('description','');

        $event->place = $place;
        $event->type = $type;
        $event->description = $description;
        $event->beginTime = $beginTime;

        $event->save();

        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>$event->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_event(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'event_id' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $id = $request->input('event_id');
        $event = Event::find($id);

        $event->isCanceled = 1;
        
        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>null]);
    }

    /**
     * Join the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_id' => 'required',
            'event_id' => 'required']);

        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $user = Account::find($account_id);
        $event = Event::find($event_id);

        $event->participant()->attach($user);
        $user->participatedEvent()->attach($event);

        return response()->json(['status'=>0,'message' => 'successfully',
            'data'=>null]);
    }
}
