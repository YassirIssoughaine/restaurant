<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $cats =Category::all();

        if(auth()->user()->is_admin ==1){
            $order=Order::orderby('id','DESC')->get();
            return view('AdminPage', compact('order'));
        }
        else{
            if(!$request->category){
                $cat1="الصفحة الرئيسية";
                $meals=Meal::all();
                return view('UserPage',compact('cats','meals','cat1'));
            }
            else{
                $cat1=$request->category;
                $meals=Meal::where('category',$request->category)->get();
                return view('UserPage',compact('cats','meals','cat1'));
            }
        }
    }

    public function orderstore(Request $request){
        Order::insert([
            'user_id' => Auth()->user()->id,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'meal_id' => $request->meal_id,
            'qty' => $request->qty,
            'adress' => $request->address,
            'status' => "تتم مراجعة الطلب",
        ]);

        $notification = array(
            'message_id' => 'تم الطلب بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('home')->with($notification);
    }

    public function show_order(){
        $order=Order::where('user_id',Auth::user()->id)->get();
        return view('order.show_order',compact('order'));
    }

    public function changeStatus(Request $request,$id){
        $order = Order::find($id);
        Order::where('id',$id)->update(['status'=> $request->status]);
        return back();
    }
}
