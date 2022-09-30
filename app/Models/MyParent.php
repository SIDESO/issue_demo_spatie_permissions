<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyParent extends Model
{
    use HasFactory;

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    public function over18(): HasMany
    {
        return $this->hasMany(Child::class)->where('age', '>=', 1);
    }

    public function under18(): HasMany
    {
        return $this->hasMany(Child::class)->where('age', '<', 18);
    }

    public function limitedView(){
        $query = $this->children();

        if(!Auth::user()->hasRole('Super-Admin')){
            $query->orWhere('age', '>=', 18);
        }

        return $query;
    }
}
