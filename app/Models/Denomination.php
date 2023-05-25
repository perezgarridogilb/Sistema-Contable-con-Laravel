<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'value', 'image'];

    public function getImagenAttribute()
    {
        if($this->image != null)
        {
            return file_exists('storage/denominations/' . $this->image) ? 'denominations/' . $this->image : '6459bd267d2bc_.jpg';
        } else {
            return '6459bd267d2bc_.jpg';
        }
    }
}
