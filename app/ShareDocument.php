<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareDocument extends Model
{
// 	protected $casts = [
//     'view_share' => 'json'
// ];

    protected $table = 'share_documents';
    
    public $timestamps = true;

    protected $fillable = ['duration_time', 'project_id','share_documents_id', 'email','register_required','printable','downloadable','acess_token'];

    // public function documents(){
    //     return $this->belongsTo(Document::class,'document_id');
    // }
}
