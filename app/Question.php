<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    
    public $timestamps = true;

    protected $fillable = ['document_id', 'group_id','ques_content', 'send_by','send_to','priority','time','created_by','updated_by'];

}
