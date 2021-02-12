<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    public function categories(){

        return $this->belongsToMany(Category::class);
    }

    public function presentPrice(){
        //return money_format('$%1',$this->price /100);
        return '$'.number_format($this->price / 100,2);
    }

    public function scopeMightAlsoWanted(Builder $query,$take){
        return $query->inRandomOrder()->take($take)->get();
    }
}
