<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return Event::where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)
                    ->get();
    }

    public function myEvents(User $user, Request $request){
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        return $user->event()
        ->where('start_date', '>=', $startDate)
        ->where('end_date', '<=', $endDate)
        ->get();
    }


    public function store(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $event = new Event();
        if($events = $event->check($startDate, $endDate)){
            return response()->json(['status' => 'Cant create event on date: ' . $startDate . ' ' . $endDate], 400);
        } else {
            $event = Event::create($request->all());
            $event->user()->attach($request->get('user_id'));
            return response()->json($event, 201);
        }

    }


    public function show(Event $event)
    {
        return response()->json($event);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, Event $event)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');


        if($events = $event->check($startDate, $endDate)){
            return response()->json(['status' => 'Cant edit event on date: ' . $startDate . ' ' . $endDate], 400);
        } else {
            $event->update($request->all());
            return response()->json([]);
        }
    }


    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([]);
    }
}
