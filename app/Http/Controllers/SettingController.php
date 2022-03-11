<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct()
    {
    //    $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_settings = Setting::where('user_id', Auth::user()->id)->first();
        if(!isset($user_settings)){
            $user_settings = (object) array(
                'user_id' => Auth::user()->id,
                'column_number' => 0,
                'order_type' => 0,
            );
        }
        $column_number_select = array(
            '0' => 'Oszlopok száma',
            '1' => 'Egy',
            '2' => 'Kettő',
            '3' => 'Három'
        );

        $column_type_select = array(
            '0' => 'Oszlop típusa',
            '1' => 'Legfrisebbek',
            '2' => 'Bejegyzések',
            '3' => 'Kommentek'
        );
        if($user_settings->column_number > 3){
            $user_settings->column_number = 3;
        }

        return view('settings', compact('user_settings', 'column_number_select', 'column_type_select'));
    }

    public function save(Request $request){

        $setting = Setting::where('user_id', Auth::user()->id)->first();

        if ($setting !== null) {
            $setting->update([
                'column_number' => $request->column_count,
                'order_type' => $request->order_type,
                'blog_visual' => 'default',
            ]);
        } else {
            $setting = Setting::create([
                'user_id' => Auth::user()->id,
                'column_number' => $request->column_count,
                'order_type' => $request->order_type,
                'blog_visual' => 'default'
            ]);
        }

        return redirect()->route('settingsindex');
    }

}
