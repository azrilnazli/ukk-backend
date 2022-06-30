<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Video extends Model
{
    use HasFactory;
    use Sortable;
    public $sortable = ['id', 'is_ready','created_at', 'updated_at'];
    protected $appends = [ 'length','date' ];
   // protected $appends = array('expired');

    public function getLengthAttribute()
    {
        //return \Carbon\Carbon::parse($this->end)->diffForHumans();
        return \Carbon\CarbonInterval::seconds($this->duration)->cascade()->forHumans();
    }

    public function getDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Video belongsTo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);

    }


   /**
     * Get the Category that owns the Video.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the Category that owns the Tender.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
    /**
     * Get the Category that owns the Video.
     */
    public function proposal()
    {
        return $this->belongsTo(TenderSubmission::class);
    }

    /**
     * Get the Statistics belongs to that Video     */
    public function statistics()
    {
        return $this->hasMany(Statistics::class);
    }
}
