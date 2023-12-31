<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        // dd(Listing::latest()->filter(request(['tag', 'search']))->paginate(5));
        return view('listings.index',[
        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        
    ]);
    
    }
    //show single listing
    public function show(Listing $listing){
     return view('listings.show',[
        'listing' => $listing
        
    ]);
    }

    //show create form
    public function create(){
     return view('listings.create');
    }

    //store listing data
    public function store(Request $request){
      
     $formfields = $request->validate([
        'title' =>'required',
        'company' =>['required', Rule::unique('listings','company')],
        'location' =>'required',
        'website' =>'required',
        'email' => ['required', 'email'],
        'tags' =>'required',
        'description' =>'required'
     ]);

        if($request->hasFile('logo')) {
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formfields['user_id'] = auth()->id();

     Listing::create($formfields);
        return redirect('/')->with('message', 'Listing created successfuly!');
     
    }

    // show edit form
    public function edit(Listing $listing){
        // dd($listing->title);
        return view('listings.edit', ['listing' => $listing]); 
    }

    //update listing data
    public function update(Request $request, Listing $listing) {
      
        // make sure logged in use is the owner
        if($listing->user_id != auth()->id() ){
        abort(403, 'Unauthorised action');
        }

     $formfields = $request->validate([
       'title' => 'required',
        'company' => ['required'],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required',
        'description' => 'required'
     ]);

        if($request->hasFile('logo')) {
            $formfields['logo'] = $request->file('logo')->store('logos', 'public');
        }

     $listing->update($formfields);

        return back()->with('message', 'Listing edited successfuly!');
     
    }
    // delete listing
    public function delete(Listing $listing){

        // make sure logged in use is the owner
        if($listing->user_id != auth()->id() ){
        abort(403, 'Unauthorised action');
        }
        
        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully');

    }
    // manage listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
