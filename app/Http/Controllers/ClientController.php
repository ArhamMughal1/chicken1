<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {

    }

    public function index(){
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function store(request $request){
        $request->validate([
            'full_name' => 'required',
            'status' => 'sometimes|boolean',
        ]);

        $client = new Client;
        $client->fill($request->all());
        $client->status = $request->has('status') ? 1 : 0;
        $client->save();
        session()->flash('success','Client Added Successfully');
        return redirect('clients');
    }

    public function edit($id){
        $clients = Client::all();

        $client = Client::find($id);
        return view('clients.index',compact('client','clients'));
    }
    public function update(request $request,$id){
        $request->validate([
            'full_name' => 'required',
            'status' => 'sometimes|boolean',
        ]);

        $client = Client::find($id);
        $client->fill($request->all());
        $client->status = $request->has('status') ? 1 : 0;
        $client->save();
        session()->flash('success','Client Updated Successfully');
        return redirect('clients');
    }
    public function destroy($id){
        $client = Client::find($id);
        $client->delete();
        session()->flash('success','Client Deleted Successfully');
        return redirect('clients');
    }
}
