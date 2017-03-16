<?php

namespace App\Http\Controllers;

use App\Estados;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class States extends Controller{

	public function getAll(){
		$data['data'] = Estados::orderBy('id', 'asc')->get();
		return $data;
	}
}