<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderPriority;
use App\Models\Currency;
use App\Models\OrderStatus;
use App\Models\FormulaPartSpecify;
use App\Http\Requests\Order as OrderRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrder;
use App\Mail\UpdateOrder;

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
            'orders.formula_part_specify_id', 'orders.currency_id', 'orders.order_priority_id', 'orders.order_status_id', 'orders.created_by_user_id'])
        ->paginate(7);
        
        $currencies = Currency::all();
        $orderPriorities = OrderPriority::all();
        $orderStatuses = OrderStatus::all();
        $formulaPartSpecifies = FormulaPartSpecify::all();

        return Inertia::render('DashboardMyOrders', [
            'orders' => $orders,
            'currencies' => $currencies,
            'orderPriorities' => $orderPriorities,
            'orderStatuses' => $orderStatuses,
            'formulaPartSpecifies' => $formulaPartSpecifies,
        ]);
    }

    public function getAllOrders(){
        $orders = Order::join('users', 'orders.created_by_user_id', '=', 'users.id')
        ->join('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
        ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id')
        ->join('currencies', 'orders.currency_id', 'currencies.id')
        ->join('formula_part_specifies', 'orders.formula_part_specify_id', 'formula_part_specifies.id')
        ->orderBy('orders.id', 'desc')
        ->select(['orders.id', 'orders.order_number', 'orders.order_title', 'orders.description', 'orders.quantity', 'orders.price_per_piece', 'orders.price_total',
            'currencies.currency_symbol', 'users.name', 'orders.shop', 'orders.link', 'order_priorities.order_priority_title', 'orders.order_comment', 
            'orders.delivery_date', 'order_statuses.order_status_title', 'formula_part_specifies.formula_part_specify_title', 'orders.approval', 'orders.created_at', 'orders.updated_at',
            'orders.formula_part_specify_id', 'orders.currency_id', 'orders.order_priority_id', 'orders.order_status_id', 'orders.created_by_user_id'])
        ->paginate(7);

        $currencies = Currency::all();
        $orderPriorities = OrderPriority::all();
        $orderStatuses = OrderStatus::all();
        $formulaPartSpecifies = FormulaPartSpecify::all();

        return Inertia::render('DashboardAllOrders', [
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
            'approval' => 2,
        ]);

        $users = User::where('active', 1)->where('id', '!=', Auth::user()->id)->where('role_id', 0)->orWhere('role_id', 1)->orWhere('role_id', 2)->get();

        foreach($users as $user){
            Mail::to('lukash.baca@gmail.com')->send(new NewOrder($request->order_number, Auth::user()->name, 1));
        }

        return redirect()->back()->with('success_object_save', 'Uložené.');
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

        if($request->approval == 1 || $request->approval == 3){
            $toUser = User::where('id', $request->created_by_user_id)->first();

            Mail::to('lukash.baca@gmail.com')->send(new UpdateOrder($request->order_number, Auth::user()->name, $request->approval));
        }

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteOrder(Request $request){
        $order = Order::where('id', $request->id)->first();

        $users = User::where('active', 1)->where('id', '!=', Auth::user()->id)->where('role_id', 0)->orWhere('role_id', 1)->orWhere('role_id', 2)->get();

        foreach($users as $user){
            Mail::to('lukash.baca@gmail.com')->send(new NewOrder($order->order_number, Auth::user()->name, 2));
        }

        $order->delete();
        
        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getSearchedOrders(Request $request){
        if($request->screen == 1){
            $searchedOrders = Order::where('orders.order_title', 'like', '%' . $request->findOrderString . '%')
            ->where('orders.created_by_user_id', Auth::user()->id)
            ->join('users', 'orders.created_by_user_id', '=', 'users.id')
            ->join('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
            ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id')
            ->join('currencies', 'orders.currency_id', 'currencies.id')
            ->join('formula_part_specifies', 'orders.formula_part_specify_id', 'formula_part_specifies.id')
            ->orderBy('orders.id', 'desc')
            ->select(['orders.id', 'orders.order_number', 'orders.order_title', 'orders.description', 'orders.quantity', 'orders.price_per_piece', 'orders.price_total',
                'currencies.currency_symbol', 'users.name', 'orders.shop', 'orders.link', 'order_priorities.order_priority_title', 'orders.order_comment', 
                'orders.delivery_date', 'order_statuses.order_status_title', 'formula_part_specifies.formula_part_specify_title', 'orders.approval', 'orders.created_at', 'orders.updated_at',
                'orders.formula_part_specify_id', 'orders.currency_id', 'orders.order_priority_id', 'orders.order_status_id', 'orders.created_by_user_id'])
            ->paginate(7);
        }
        else{
            $searchedOrders = Order::where('orders.order_title', 'like', '%' . $request->findOrderString . '%')
            ->join('users', 'orders.created_by_user_id', '=', 'users.id')
            ->join('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
            ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id')
            ->join('currencies', 'orders.currency_id', 'currencies.id')
            ->join('formula_part_specifies', 'orders.formula_part_specify_id', 'formula_part_specifies.id')
            ->orderBy('orders.id', 'desc')
            ->select(['orders.id', 'orders.order_number', 'orders.order_title', 'orders.description', 'orders.quantity', 'orders.price_per_piece', 'orders.price_total',
                'currencies.currency_symbol', 'users.name', 'orders.shop', 'orders.link', 'order_priorities.order_priority_title', 'orders.order_comment', 
                'orders.delivery_date', 'order_statuses.order_status_title', 'formula_part_specifies.formula_part_specify_title', 'orders.approval', 'orders.created_at', 'orders.updated_at',
                'orders.formula_part_specify_id', 'orders.currency_id', 'orders.order_priority_id', 'orders.order_status_id', 'orders.created_by_user_id'])
            ->paginate(7);
        }

        return $searchedOrders;
    }
}
