<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ElearningController extends Controller
{
    public function login_ead()
    {	
           
          $this->middleware('guest')->except('logout');
    	
    	return view('login/login_elearning');
    }

    public function santander_rci_licao_00()
    {
        return view('aula_santander_rci');

    }

}
