<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the ticket types for a specific event.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        return response()->json($event->tickets, 200);
    }

    /**
     * Store a newly created ticket type for an event.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request, Event $event)
    {
        $ticket = new Ticket($request->validated());
        $event->tickets()->save($ticket);

        return response()->json($ticket, 201);
    }

    /**
     * Display the specified ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, Ticket $ticket)
    {
        return response()->json($ticket, 200);
    }

    /**
     * Update the specified ticket.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, Event $event, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return response()->json($ticket);
    }

    /**
     * Remove the specified ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(null, 204);
    }

    /**
     * Mark a ticket as checked in.
     *
     * @param  int  $ticketId
     * @return \Illuminate\Http\Response
     */
    public function checkIn($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        if ($ticket->status == 'refunded' || $ticket->status == 'checked_in') {
            return response()->json(['message' => 'Cannot check-in a refunded or already checked-in ticket.'], 400);
        }

        $ticket->update(['status' => 'checked_in']);

        return response()->json(['message' => 'Ticket successfully checked in.']);
    }
}
