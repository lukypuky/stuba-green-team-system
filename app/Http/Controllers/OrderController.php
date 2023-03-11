<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Order;
use App\Models\OrderPriority;
use App\Models\Currency;
use App\Models\OrderStatus;
use App\Models\FormulaPartSpecify;
use App\Http\Requests\Order as OrderRequest;

class OrderController extends Controller
{
    public function getMyOrders(){
        $orders = Order::where('orders.created_by_user_id', Auth::user()->id)
        ->join('users', 'orders.created_by_user_id', '=', 'users.id')
        ->join('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
        ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id')
        ->join('currencies', 'orders.currency_id', 'currencies.id')
        ->join('formula_part_specifies', 'orders.formula_part_specify_id', 'formula_part_specifies.id')
        ->orderBy('orders.id', 'desc')
        ->select(['orders.id', 'orders.order_number', 'orders.order_title', 'orders.description', 'orders.quantity', 'orders.price_per_piece', 'orders.price_total',
            'currencies.currency_symbol', 'users.name', 'orders.shop', 'orders.link', 'order_priorities.order_priority_title', 'orders.order_comment', 
            'orders.delivery_date', 'order_statuses.order_status_title', 'formula_part_specifies.formula_part_specify_title', 'orders.approval', 'orders.created_at', 'orders.updated_at',
            'orders.formula_part_specify_id', 'orders.currency_id', 'orders.order_priority_id', 'orders.order_status_id'])
        ->get();

        $currencies = Currency::all();
        $orderPriorities = OrderPriority::all();
        $orderStatuses = OrderStatus::all();
        $formulaPartSpecifies = FormulaPartSpecify::all();

        return Inertia::render('DashboardOrders', [
            'orders' => $orders,
            'currencies' => $currencies,
            'orderPriorities' => $orderPriorities,
            'orderStatuses' => $orderStatuses,
            'formulaPartSpecifies' => $formulaPartSpecifies,
        ]);
    }

    public function storeOrder(OrderRequest $request){
        Order::create([
            'order_number' => $request->order_number,
            'order_title' => $request->order_title,
            'description' => $request->description,
            'formula_part_specify_id' => $request->formula_part_specify_id,
            'created_by_user_id' => Auth::user()->id,
            'quantity' => $request->quantity,
            'price_per_piece' => $request->price_per_piece,
            'price_total' => $request->price_total,
            'currency_id' => $request->currency_id,
            'shop' => $request->shop,
            'link' => $request->link,
            'order_priority_id' => $request->order_priority_id,
            'order_status_id' => $request->order_status_id,
            'order_comment' => $request->order_comment,
            'approval' => 3,
        ]);

        return redirect()->back()->with('success_order_save', 'uspesny order save');
    }

    public function updateOrder(OrderRequest $request){
        Order::where('id', $request->id)->update([
            'order_number' => $request->order_number,
            'order_title' => $request->order_title,
            'description' => $request->description,
            'formula_part_specify_id' => $request->formula_part_specify_id,
            'quantity' => $request->quantity,
            'price_per_piece' => $request->price_per_piece,
            'price_total' => $request->price_total,
            'currency_id' => $request->currency_id,
            'shop' => $request->shop,
            'link' => $request->link,
            'order_priority_id' => $request->order_priority_id,
            'order_status_id' => $request->order_status_id,
            'order_comment' => $request->order_comment,
            'delivery_date' => $request->delivery_date,
            'approval' => $request->approval,
        ]);

        return redirect()->back()->with('success_order_update_save', 'uspesny order update save');
    }

    public function deleteOrder(Request $request){
        Order::where('id', $request->id)->delete();

        return redirect()->back()->with('success_order_delete', 'uspesny order delete');
    }
}
