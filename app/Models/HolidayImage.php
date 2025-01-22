<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
class HolidayImage extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayImageFactory> */
    use HasFactory;
    public function holiday () {
        return $this->belongsTo(Holiday::class);
    }
    public function path($size='large')
    {
        return Storage::disk('holidayImages')->path($this->holiday_id.'/'.$size.'_'.$this->name);
    }
    public function url($size='large')
    {
        return Storage::disk('holidayImages')->url($this->holiday_id.'/'.$size.'_'.$this->name);
    }
}
