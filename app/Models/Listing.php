<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = ['company', 'title' , 'description' , 'tags', 'website', 'email' , 'location', 'logo'];

    public function scopeFilter($query, array $filters){
        if($filters['tag']  ?? false) {
            $query->where('tags', 'like', '%' . request('tag').'%');
        }
        if($filters['search']  ?? false) {
            $query->where('description', 'like', '%' . request('search').'%')
            ->orWhere('title', 'like', '%' . request('search').'%')
            ->orWhere('tags', 'like', '%' . request('search').'%');
        }
       
    }
    // relationship with user
    public function user(){
        return $this->belongs(User::class, 'user_id');
    }
}

