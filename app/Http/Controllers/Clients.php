<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class Clients extends Controller
{
    //

    public function index($id = null){
    	if($id == null){
    		$data['data'] = Client::orderBy('id', 'asc')->get();
            return $data;
    	}else{
            $data = $this->show($id);
    		return $data;
    	}
    }

    public function store(Request $request){
    	$client = new Client;

    	$client->name = $request->input('name');
    	$client->last_name = $request->input('last_name');
    	$client->second_last_name = $request->input('second_last_name');
    	$client->email = $request->input('email');
    	$client->birth = $request->input('birth');
    	$client->birth_state = $request->input('birth_state');

    	$client->save();

    	return "Client succesfully created with id " . $client->id;

    }

    public function show($id){
        $data['data'] = Client::find($id);
    	return $data;
    }

    public function update(Request $request, $id){

    	$client = Client::find($id);

    	$client->name = $request->input('name');
    	$client->last_name = $request->input('last_name');
    	$client->second_last_name = $request->input('second_last_name');
    	$client->email = $request->input('email');
    	$client->birth = $request->input('birth');
    	$client->birth_state = $request->input('birth_state');
    	$client->save();

    	return "Success updating user # " . $client->id;

    }

    public function destroy($id){

        
    	$client = Client::findOrFail($id);

        $client->delete();

    	return "Client record Successfully deleted #" . $id;
    }

}
