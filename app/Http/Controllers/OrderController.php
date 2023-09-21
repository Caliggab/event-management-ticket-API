<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // You can include filters based on the parameters specified earlier (by ticket type, attendee, etc.)
        $orders = Order::all();

        return response()->json($orders);
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return response()->json($order);
    }

    /**
     * Refund the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refund(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'refunded') {
            return response()->json(['message' => 'Order is already refunded.'], 400);
        }

        foreach ($order->tickets as $ticket) {
            if ($ticket->status == 'checked_in') {
                return response()->json(['message' => 'Cannot refund an order with a checked-in ticket.'], 400);
            }
        }



        $order->update(['status' => 'refunded']);

        // update ticket count
        foreach ($order->tickets as $ticket) {
            $ticketType = $ticket->ticketType; 
            $ticketType->increment('available_count');
            $ticket->update(['status' => 'refunded']);
        }


        return response()->json(['message' => 'Order successfully refunded.']);

        //chequear logica y stripe
    }
}
