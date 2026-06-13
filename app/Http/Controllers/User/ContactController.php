<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $data['breadcrumb_title'] = 'Contact';
        return view('users.contact',$data);
    }
}
