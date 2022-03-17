<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Auth;

class Pagesettings extends Component
{
    public $column_id;
    public $col1;
    public $col2;
    public $col3;
    public $selectables = [[
        1 => 'Posts',
    ]];

    public $onecolumn = [[
        1 => 'Posts',
    ]];

    public $twocolumns = [[
        1 => 'Most Related',
        2 => 'Posts',
        3 => 'Comments'
    ],[
        1 => 'Most Related',
        2 => 'Posts',
        3 => 'Comments'
    ]];

    public $threecolumns = [[
        1 => 'Most Related',
        3 => 'Comments'
    ],[
        2 => 'Posts',
    ],[
        1 => 'Most Related',
        3 => 'Comments'
    ]];

    public $column_count = [
        1 => '1',
        2 => '2',
        3 => '3'
    ];

    public $column_type_id = '';
    public $column_count_id = '1';

    public function render()
    {
        return view('livewire.pagesettings')->extends('layouts.app');
    }

    public function changeType($colid, $value)
    {   
        if($this->column_count_id == 1){
            $this->col1 = 1; 
        }
        if($this->column_count_id == 2){
                switch($colid){
                    case 0:
                        break;
                    case 1:
                        if($this->col2 != $value){
                            $this->col1 = $value;
                        }else{
                            $this->col2 = 1;
                        }
                        if($value != 2){
                            $this->col2 = 2;
                        }
                        break;
                    case 2:
                        if($this->col1 != $value){
                            $this->col2 = $value;
                        }else{
                            $this->col1 = 1;
                        }
                        if($value != 2){
                            $this->col1 = 2;
                        }
                        break;
            }
        }
        if($this->column_count_id == 3){
            $this->col2 = 2;
                switch($colid){
                    case 0:
                        break;
                    case 1:
                        if($value == 1){
                            $this->col3 = 3;
                        }
                        if($value == 3){
                            $this->col3 = 1;
                        }
                        $this->col1 = $value;
                        break;
                    case 3:
                        $this->col3 = $value;
                        if($value == 1){
                            $this->col1 = 3;
                        }
                        if($value == 3){
                            $this->col1 = 1;
                        }
                        break;
                }
            
        }
    }

    public function changeCount($value)
    {
        $this->column_count_id = $value;
        $this->col1 = null; 
        $this->col2 = null; 
        $this->col3 = null; 
        switch($value){
        case 0:
            $this->selectables = $this->onecolumn;
            $this->col1 = 1;
            $this->column_count_id = 1;
            break;
        case 1:
            $this->selectables = $this->onecolumn;
            $this->col1 = 1;
            break;
        case 2:
            $this->selectables = $this->twocolumns;
            $this->col1 = 1;
            $this->col2 = 2;
            break;
        case 3:
            $this->selectables = $this->threecolumns;
            $this->col1 = 1;
            $this->col2 = 2;
            $this->col3 = 3;
            break;
        }
    }
    public function savesettings(){

        Setting::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'col_count' =>  $this->column_count_id,
                'col_first' => $this->col1,
                'col_second' => $this->col2,
                'col_third' => $this->col3
            ]);

    }
   
}
