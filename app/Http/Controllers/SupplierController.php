<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function __construct()
    {

    }

    public function index(){
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(request $request){
        $request->validate([
            'full_name' => 'required',
            'status' => 'sometimes|boolean',
        ]);

        $supplier = new Supplier();
        $supplier->fill($request->all());
        $supplier->status = $request->has('status') ? 1 : 0;
        $supplier->save();
        session()->flash('success','Supplier Added Successfully');
        return redirect('suppliers');
    }

    public function edit($id){
        $suppliers = Supplier::all();
        $supplier = Supplier::find($id);
        return view('suppliers.index',compact('supplier','suppliers'));
    }
    public function update(request $request,$id){
        $request->validate([
            'full_name' => 'required',
            'status' => 'sometimes|boolean',
        ]);

        $supplier = Supplier::find($id);
        $supplier->fill($request->all());
        $supplier->status = $request->has('status') ? 1 : 0;
        $supplier->save();
        session()->flash('success','Supplier Updated Successfully');
        return redirect('suppliers');
    }
    public function destroy($id){
        $supplier = Supplier::find($id);
        $supplier->delete();
        session()->flash('success','Supplier Deleted Successfully');
        return redirect('suppliers');
    }
}
