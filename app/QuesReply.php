<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuesReply extends Model
{
    protected $table = 'question_reply';
    
    public $timestamps = true;

    protected $fillable = ['document_id', 'question_id','project_id', 'reply_by','reply_to', 'time','reply_subject','reply_content', 'reply_status'];

}
