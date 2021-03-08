<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use Laravel\Scout\Searchable;
use Illuminate\Support\Arr;

class Product extends Model
{
    use HasFactory;
    use Searchable;

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

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array = Arr::except($array, ["id","slug","price","created_at","updated_at","image"]);
        
        // Customize the data array...

        return $array;
    }
}
