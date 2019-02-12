<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavDocument extends Model
{
    protected $table = 'fav_documents';
    
    public $timestamps = true;

    protected $fillable = ['project_id', 'document_id','user_id'];
}
