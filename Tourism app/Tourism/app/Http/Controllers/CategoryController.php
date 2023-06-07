<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TouristDes;

use Validator;

class CategoryController extends Controller
{
    //get_all_categories
    public function index()
    {
        $Category= Category::select('id' , 'name')->get();
        return response()->json($Category);
    }

    //search_for_tourist_des_by_its_cat_id
    public function search($id){
        $cat = TouristDes::select('*')->where('categ_id', $id )
        ->get()->toArray();
        return response()->json($cat);

    }

    //add_new_cat
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $Category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' =>"$Category->name added successfully",
        ]);

    }

    //update_cat
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        };

        //update Category by its id and save the changes
        $Category_up=Category::findOrFail($id);
        $Category_up->name=$request->input('name');
        $Category_up->save();

        return response()->json([
            'message' =>"  updated successfully",
        ]);
    }

    //delete_cat
    public function destroy($id)
    {
        $d_Category=Category::findOrFail($id);
        $d_Category->delete();

        return response()->json([
            'message' =>"Category $id deleted successfully",
        ]);
    }
}
