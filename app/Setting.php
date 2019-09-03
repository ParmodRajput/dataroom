<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    
    public $timestamps = true;

    protected $fillable = ['watermark_view', 'watermark_text','watermark_color', 'project_id','downloadable','printable','discussable'];
}
