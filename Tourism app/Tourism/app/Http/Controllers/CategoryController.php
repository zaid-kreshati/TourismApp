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

    //Get All destinations by category
    public function search($id){
        $desinations = TouristDes::with('image' , 'category' , 'country')->where('categ_id', $id )->get();

        $data = $desinations->map(function($dest) {
            return [
                'name'=> $dest->name,
                'details'=> $dest->details,
                'category'=> $dest->category->name,
                'image'=> $dest->image->data,
                'country'=> $dest->country->name,
            ];
        });

        return response()->json($data);

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
