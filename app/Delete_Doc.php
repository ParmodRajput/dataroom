<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delete_Doc extends Model
{
    protected $table = 'delete_documents';
    
    public $timestamps = true;

    protected $fillable = ['deleted_document', 'deleted_from','deleted_by', 'restored_by','deleted_time', 'restored_time'];
}
