<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function dashboard(){
        $user = User::findOrFail(Auth::id());
        return view('frontend.pages.user.dashboard', compact('user'));
    }

    public function orders(){
        $user = User::findOrFail(Auth::id());
        return view('frontend.pages.user.order', compact('user'));
    }

    public function invoice($user_id, $order_id){
        $user = User::findOrFail(Auth::id());
        $order = Order::whereNotNull('user_id')->where('user_id', $user_id)->where('order_id', $order_id)->where('order_source', 'website')->first();
        if(!$user || !$order){
            return redirect()->back()->with('error', 'Order not found');
        }
        return view('frontend.pages.user.invoice', compact('order', 'user'));
    }

    public function editProfile(){
        $user = User::findOrFail(Auth::id());
        return view('frontend.pages.user.edit-profile', compact('user'));
    }

    public function updatePassword(){
        $user = User::findOrFail(Auth::id());
        return view('frontend.pages.user.update-password', compact('user'));
    }

    public function wishlist(){
        $user = User::findOrFail(Auth::id());
        return view('frontend.pages.user.my-wishlist', compact('user'));
    }


}
