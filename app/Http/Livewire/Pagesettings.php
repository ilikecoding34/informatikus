<?php

namespace App\Http\Livewire;

use Livewire\Component;

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

    public function changeType($iter, $value)
    {   
        if($this->column_count_id == 1){
            $this->col1 = 1; 
        }
        if($this->column_count_id == 2){
                switch($iter){
                    case 0:
                        break;
                    case 1:
                        if($this->col2 != $value){
                            $this->col1 = $value;
                        }
                        if($value != 2){
                            $this->col2 = 2;
                        }
                        break;
                    case 2:
                        if($this->col1 != $value){
                            $this->col2 = $value;
                        }
                        if($value != 2){
                            $this->col1 = 2;
                        }
                        break;
            }
        }
        if($this->column_count_id == 3){
            $this->col2 = 2;
                switch($iter){
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
        $this->col1 = ''; 
        $this->col2 = ''; 
        $this->col3 = ''; 
        switch($value){
        case 0:
            $this->selectables = $this->onecolumn;
            $this->col1 = 1; 
            break;
        case 1:
            $this->selectables = $this->onecolumn;
            break;
        case 2:
            $this->selectables = $this->twocolumns;
            break;
        case 3:
            $this->selectables = $this->threecolumns;
            $this->col2 = 2;
            break;
        }
    }
}
