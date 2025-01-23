<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessDeleteRequest;
use App\Http\Requests\StoreBusinessRequest;
use App\Models\Business;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class BusinessController extends Controller
{

    public function index()
    {
        if( request()->ajax() )
        {
            $business = Business::latest()->get();
            return DataTables::of($business)
                             ->addColumn('logo', function ($business)
                             {

                                 return ( $business->logo ) ? '<img src="' . Storage::url($business->logo) . '" alt="Logo" style="width: 50px; height: auto;">' : '';
                             })
                             ->addColumn('action', function ($business)
                             {
                                 return '<form action="' . route('businesses.destroy', $business->id) . '" method="POST" style="display: inline-block">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this business?\')">Delete</button>
                                        </form>';
                             })
                             ->rawColumns([ 'action', 'logo' ])
                             ->make(true);
        }

        return view('business.index');
    }


    public function create()
    {
        return view('business.create');
    }

    public function store(StoreBusinessRequest $request)
    {

        $business        = new Business();
        $business->name  = $request->name;
        $business->email = $request->email;
        $business->phone = $request->phone;

        if( $request->hasFile('logo') )
        {
            $logoPath       = $request->file('logo')->store('logos', 'public');
            $business->logo = $logoPath;
        }

        $business->save();

        return redirect()->route('businesses.index')->with('success', 'Business created successfully!');
    }


    public function destroy(BusinessDeleteRequest $request, $business)
    {
        try
        {
            $business = Business::findOrFail($business);
            $business->delete();
            return redirect()->route('businesses.index')->with('success', 'Business deleted successfully!');
        }
        catch( ModelNotFoundException $e )
        {
            return redirect()->route('businesses.index')->with('error', 'Business not found.');
        }
        catch( Exception $e )
        {
            return redirect()->route('businesses.index')->with('error', 'An error occurred while trying to delete the business.');
        }
    }

}
