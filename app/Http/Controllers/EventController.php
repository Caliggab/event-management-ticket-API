<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::paginate(10);
        return response()->json($events, 200);
    }

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = new Event($request->all());
        $event->id = Str::uuid();
        $event->user_id = auth()->id();

        $event->save();

        return response()->json(['message' => 'Event created successfully!', 'event' => $event], 201);
    }


    /**
     * Display the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return response()->json($event, 200);
    }

    /**
     * Update the specified event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $event->update($request->all());

        return response()->json(['message' => 'Event updated successfully!', 'event' => $event], 200);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // if ($event->hasRelatedOrders()) {
        //     return response()->json(['message' => 'Event cannot be deleted as it has related orders.'], 403);
        // }

        $event->delete();
        return response()->json(['message' => 'Event deleted successfully!'], 204);
    }
}
