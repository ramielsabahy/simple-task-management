<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','due_date','status', 'user_id'];

    public function ScopeSearch($query)
    {
        $query->when(request()->has('search'), function ($quer) {
            $quer->where(function ($search) {
                $search->where('title', 'LIKE', '%'.request()->search.'%')
                    ->orWhere('description', 'LIKE', '%'.request()->search.'%');
            });
        });
    }

    public function ScopeFilter($query)
    {
        $query->when(request()->has('completion'), function ($quer) {
            $quer->where('status', request()->completion);
        });
    }

    public function ScopeOwner($query)
    {
        $query->where('user_id', request()->user()->id)->orWhere(function ($query){
            $query->whereHas('collaborations', function ($collaborator) {
                $collaborator->where('user_id', request()->user()->id);
            });
        });
    }

    public function collaborations()
    {
        return $this->hasMany(Collaboration::class);
    }

    public function images(){
        return $this->hasMany(Attachment::class);
    }
}
