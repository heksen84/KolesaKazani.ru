<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;

class CategoriesController extends Controller
{

    public function index() {
	     return Categories::all()->toJson();
    }

    public function getCategoryItems(Request $request) {
        /*$store = Store::all(); // got this from database model
        return view('store')->with('store', $store);*/ 

	     //return view('categories')->with("search_string", ucfirst($request->item));
        return view('categories')->with("items", null);

       /*

       Products::whereIn('id', function($query){
         $query->select('paper_type_id')
         ->from(with(new ProductCategory)->getTable())
         ->whereIn('category_id', ['223', '15'])
         ->where('active', 1);
       })->get();

       */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
    }
}
