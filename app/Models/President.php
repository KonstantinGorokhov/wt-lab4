<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class President extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "slug",
        "name_ru",
        "name_en",
        "period",
        "short_description",
        "full_description",
        "image_path",
        "term_start",
        "term_end",
        "user_id",
    ];

    protected $casts = [
        "term_start" => "date",
        "term_end" => "date",
    ];

    protected $dates = ["deleted_at"];

    /* =======================
       Relations
    ======================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presidents()
    {
        return $this->hasMany(President::class);
    }

    /* =======================
       Mutators
    ======================= */

    public function setTermStartAttribute($value)
    {
        $this->attributes["term_start"] = $value
            ? Carbon::parse($value)->format("Y-m-d")
            : null;
    }

    public function setTermEndAttribute($value)
    {
        $this->attributes["term_end"] = $value
            ? Carbon::parse($value)->format("Y-m-d")
            : null;
    }

    /* =======================
       Accessors
    ======================= */

    public function getTermPeriodFormattedAttribute()
    {
        if (!$this->term_start && !$this->term_end) {
            return $this->period;
        }

        $start = $this->term_start ? $this->term_start->format("Y") : "?";
        $end = $this->term_end ? $this->term_end->format("Y") : "н.в.";

        return "{$start} – {$end}";
    }
}
