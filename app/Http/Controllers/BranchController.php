<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchDeleteRequest;
use App\Http\Requests\BusinessDeleteRequest;
use App\Http\Requests\StoreBranchRequest;
use App\Models\Branch;
use App\Models\BranchAvailability;
use App\Models\Business;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    public function index()
    {
        if( request()->ajax() )
        {
            $branches = Branch::with('business')->latest()->get(); // Eager load the 'business' relationship

            return DataTables::of($branches)
                             ->addColumn('business_name', function ($branch)
                             {
                                 return $branch->business->name;
                             })->addColumn('images', function ($branch)
                {
                    if( $branch->images )
                    {
                        foreach( json_decode($branch->images) as $image )
                        {
                            $paths[] = Storage::url($image);
                        }
                    }
                    return $paths;
                })
                             ->addColumn('action', function ($branch)
                             {
                                 return '<form action="' . route('branches.destroy', $branch->id) . '" method="POST" style="display: inline-block">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this branch?\')">Delete</button>
                        </form>';
                             })
                             ->rawColumns([ 'action', 'business_name', 'images' ])
                             ->make(true);
        }

        return view('branch.index');
    }


    public function store(StoreBranchRequest $request)
    {

        $imagePaths = [];
        if( $request->hasFile('images') )
        {
            foreach( $request->file('images') as $image )
            {
                $imagePaths[] = $image->store('images/branches', 'public'); // Store image in 'public/images/branches' folder
            }
        }

        $branch = Branch::create([
            'business_id' => $request->business_id,
            'name'        => $request->name,
            'images'      => json_encode($imagePaths),
        ]);

        $days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];

        foreach( $days as $day )
        {
            $startTimes = $request->{$day}[ 'start_date' ] ?? [];
            $endTimes   = $request->{$day}[ 'end_date' ] ?? [];

            $isUnavailable = empty(array_filter($startTimes)) && empty(array_filter($endTimes));

            foreach( $startTimes as $key => $startTime )
            {
                $endTime = $endTimes[ $key ] ?? null;

                if( $startTime && $endTime )
                {
                    BranchAvailability::create([
                        'branch_id'  => $branch->id,
                        'day'        => $day,
                        'start_time' => $startTime,
                        'end_time'   => $endTime,
                        'status'     => 'open',
                    ]);
                }
            }

            if( $isUnavailable )
            {
                BranchAvailability::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'day'       => $day,
                    ],
                    [
                        'status'     => 'closed',
                        'start_time' => null,
                        'end_time'   => null,
                    ]
                );
            }
        }

        return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
    }

    public function create()
    {
        $days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];
        return view('branch.create')->with('businesses', Business::list())->with('days', $days);
    }

    public function destroy(BranchDeleteRequest $request, $branch)
    {
        try
        {
            $business = Branch::findOrFail($branch);
            $business->delete();
            return redirect()->route('branches.index')->with('success', 'Branch deleted successfully!');
        }
        catch( ModelNotFoundException $e )
        {
            return redirect()->route('branches.index')->with('error', 'Branch not found.');
        }
        catch( \Exception $e )
        {
            return redirect()->route('branches.index')->with('error', 'An error occurred while trying to delete the business.');
        }
    }

}
