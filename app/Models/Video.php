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
    protected $appends = [ 'length','date','uploaded_size' ];
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

    public function getUploadedSizeAttribute()
    {
        return $this->formatBytes($this->filesize);
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
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
