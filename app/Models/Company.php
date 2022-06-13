<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Company extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];
    
    public $sortable = ['id', 'name', 'email', 'status','created_at', 'updated_at'];

    /**
     * Company belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Company hasMany Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // states to lower case
    public function setStatesAttribute($value)
    {
        $this->attributes['states'] = strtolower($value);
    }

    // states to first letter uppercase
    public function getStatesAttribute()
    {
        return ucWords($this->attributes['states']);
    }


}
