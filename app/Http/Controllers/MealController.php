<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use App\Models\Meal;

class MealController extends Controller
{
    public function create(){
        $cats = Category::latest()->get();
        return view('Meal.create_meal',compact('cats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'description' => 'required|min:3|max:500',
            'price' => 'required|numeric',
            'image' => 'required|mimes:png,jpeg,jpg',
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/Meals/'. $name_gen);
        $save_url = $name_gen;

        Meal::insert([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $save_url,
        ]);

        $notification = array(
            'message_id' => 'تم اضافة وجبة جديدة!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function index(){
        $meals = Meal::paginate(2);
        return view('meal.index',compact('meals'));
    }

    public function edit($id){
        $meal = Meal::find($id);

        $cats = Category::latest()->get();

        return view('meal.edit_meal',compact('meal','cats'));
    }

    public function update(Request $request , $id){
        $old_img = $request->old_image;

        if($request->file('imge')) {
            unlink($old_img);
            $image = $request->file('image');

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(300,300)->save('upload/Meals/' . $name_gen);

            $save_url = 'upload/Meals/' . $name_gen;

            Meal::findOrFail($id)->update([
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $save_url,
            ]);
            return redirect()-> route('meal.index')->with('message','تم تعديل الوجبة بنجاح!');
        }
        else{
            Meal::findOrFail($id)->update([
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);
            return redirect()-> route('meal.index')->with('message','تم تعديل الوجبة بنجاح!');
        }
    }

    public function show_details($id){
        $meal = Meal::findOrFail($id);
        return view('Meal.meal_details',compact('meal'));
    } 
}
