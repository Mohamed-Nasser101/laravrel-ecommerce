<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    public function presentPrice(){
        //return money_format('$%1',$this->price /100);
        return '$'.number_format($this->price / 100,2);
    }

    public function scopeMightAlsoWanted(Builder $query,$take){
        return $query->inRandomOrder()->take($take)->get();
    }
}
