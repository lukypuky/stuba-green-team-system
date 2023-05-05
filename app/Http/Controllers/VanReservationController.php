<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\VanReservation;
use App\Models\User;
use App\Http\Requests\VanReservation as VanReservationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReservation;
use App\Mail\UpdateReservation;
use Carbon\Carbon;

class VanReservationController extends Controller
{
    public function getVanReservations(){
        $vanReservations = VanReservation::join('users', 'van_reservations.user_id', '=', 'users.id')
        ->orderBy('van_reservations.id', 'desc')
        ->select(['van_reservations.id', 'van_reservations.reason', 'van_reservations.user_id', 'users.name', 'van_reservations.reservation_from',
            'van_reservations.reservation_to', 'van_reservations.approval', 'van_reservations.created_at', 'van_reservations.updated_at'])
        ->paginate(7);

        return Inertia::render('DashboardVanReservations', [
            'vanReservations' => $vanReservations,
        ]);
    }

    public function storeVanReservation(VanReservationRequest $request){
        $reservationFrom = Carbon::parse($request->reservation_from)->format('Y-m-d\ H:i:s');
        $reservationTo = Carbon::parse($request->reservation_to)->format('Y-m-d\ H:i:s');

        $from = VanReservation::whereBetween('reservation_from', [$reservationFrom, $reservationTo])->get();
        $to = VanReservation::whereBetween('reservation_to', [$reservationFrom, $reservationTo])->get();
        
        if($from->count() != 0 || $to->count() != 0){
            return redirect()->back()->withErrors(['booked' => 'Rezervácia v danom čase už existuje']);
        }

        VanReservation::create([
            'reason' => $request->reason,
            'reservation_from' => $reservationFrom,
            'reservation_to' => $reservationTo,
            'user_id' => Auth::user()->id,
            'approval' => 2,
        ]);

        $users = User::where('active', 1)->where('id', '!=', Auth::user()->id)->where('role_id', 0)->orWhere('role_id', 1)->get();

        foreach($users as $user){
            Mail::to('lukash.baca@gmail.com')->send(new NewReservation(Carbon::parse($reservationFrom)->format('d.m.Y\ H:i:s'), Carbon::parse($reservationTo)->format('d.m.Y\ H:i:s'), Auth::user()->name, 1));
        }

        return redirect()->back()->with('success_object_save', 'Uložené.');
    }

    public function updateReservation(VanReservationRequest $request){
        $reservationFrom = Carbon::parse($request->reservation_from)->format('Y-m-d\ H:i:s');
        $reservationTo = Carbon::parse($request->reservation_to)->format('Y-m-d\ H:i:s');

        $from = VanReservation::where('id', '!=', $request->id)->whereBetween('reservation_from', [$reservationFrom, $reservationTo])->get();
        $to = VanReservation::where('id', '!=', $request->id)->whereBetween('reservation_to', [$reservationFrom, $reservationTo])->get();
        
        if($from->count() != 0 || $to->count() != 0){
            return redirect()->back()->withErrors(['booked' => 'Rezervácia v danom čase už existuje']);
        }

        VanReservation::where('id', $request->id)->update([
            'reason' => $request->reason,
            'reservation_from' => $reservationFrom,
            'reservation_to' => $reservationTo,
            'approval' => $request->approval,
        ]);

        if($request->approval == 1 || $request->approval == 3){
            $toUser = User::where('id', $request->user_id)->first();

            Mail::to('lukash.baca@gmail.com')->send(new UpdateReservation(Carbon::parse($reservationFrom)->format('d.m.Y\ H:i:s'), Carbon::parse($reservationTo)->format('d.m.Y\ H:i:s'), Auth::user()->name, $request->approval));
        }

        return redirect()->back()->with('success_object_update_save', 'Upravené.');
    }

    public function deleteReservation(Request $request){
        $vanReservation = VanReservation::where('id', $request->id)->first();
    
        $users = User::where('active', 1)->where('id', '!=', Auth::user()->id)->where('role_id', 0)->orWhere('role_id', 1)->get();
    
        foreach($users as $user){
            Mail::to('lukash.baca@gmail.com')->send(new NewReservation(Carbon::parse($vanReservation->reservation_from)->format('d.m.Y\ H:i:s'), Carbon::parse($vanReservation->reservation_to)->format('d.m.Y\ H:i:s'), Auth::user()->name, 2));
        }

        $vanReservation->delete();

        return redirect()->back()->with('success_object_delete', 'Odstránené.');
    }

    public function getSearchedVanReservations(Request $request){
        $searchedVanReservations = VanReservation::where('users.name', 'like', '%' . $request->findNameString . '%')
        ->join('users', 'van_reservations.user_id', '=', 'users.id')
        ->orderBy('van_reservations.id', 'desc')
        ->select(['van_reservations.id', 'van_reservations.reason', 'van_reservations.user_id', 'users.name', 'van_reservations.reservation_from',
            'van_reservations.reservation_to', 'van_reservations.approval', 'van_reservations.created_at', 'van_reservations.updated_at'])
        ->paginate(7);

        return $searchedVanReservations;
    }
}
