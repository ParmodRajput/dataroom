<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    
    public $timestamps = true;

    protected $fillable = ['project_id', 'document_name','path', 'type'];
}
