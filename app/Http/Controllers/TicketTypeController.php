<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketTypeRequest;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of ticket types for an event.
     */
    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes;

        return response()->json(['data' => $ticketTypes], 200);
    }

    /**
     * Store a newly created ticket type for an event.
     */
    public function store(TicketTypeRequest $request, Event $event)
    {
        $ticketType = new TicketType($request->validated());
        $event->ticketTypes()->save($ticketType);

        return response()->json(['message' => 'Ticket type created successfully.', 'data' => $ticketType], 201);
    }

    /**
     * Display the specified ticket type of an event.
     */
    public function show(Event $event, TicketType $ticketType)
    {
        return response()->json(['data' => $ticketType], 200);
    }

    /**
     * Update the specified ticket type of an event.
     */
    public function update(TicketTypeRequest $request, Event $event, TicketType $ticketType)
    {
        // Ensure the ticket type belongs to the event
        if ($event->id !== $ticketType->event_id) {
            return response()->json(['message' => 'Mismatch between event and ticket type.'], 400);
        }

        $ticketType->update($request->validated());

        return response()->json(['message' => 'Ticket type updated successfully.', 'data' => $ticketType], 200);
    }

    /**
     * Remove the specified ticket type from storage.
     */
    public function destroy(Event $event, TicketType $ticketType)
    {
        if ($event->id !== $ticketType->event_id) {
            return response()->json(['message' => 'Mismatch between event and ticket type.'], 400);
        }

        $ticketType->delete();

        return response()->json(['message' => 'Ticket type deleted successfully.'], 204);
    }
}
