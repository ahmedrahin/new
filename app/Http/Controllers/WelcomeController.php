<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\OrderRepository;

class WelcomeController extends Controller
{
    use OrderRepository;
    public function home(){
        $result = [];
        $result['data'] = $this->all();
        return view('pages/welcome', $result);
    }
}
