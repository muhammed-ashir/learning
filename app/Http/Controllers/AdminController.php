<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $status= $row->status==1?"checked":"";
                       
                        return'<label class="switch">
                                <input onclick="isEnabled('.$row->id.')" type="checkbox"'.$status.'>
                                <span class="slider round"></span>
                                </label>';
    
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin');
    }

    public function status(Request $request)
    {
        $data = Customer::find($request->id);
        $data->status = $data->status==1?0:1;
        $changed = $data->save();

        if ($changed) {
            return [
                'status'=>true,
                'msg'=> $data->status==1?'Successfully Blocked Employee':'Successfully Enabled Employee'
            ];
        }
    }
}
