<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailMaster extends Model
{
    protected $table = 'mail_master';
    protected $primaryKey = 'mail_master_id';


    public function mail_log()
    {
        return $this->hasMany(MailLog::class, 'mail_master_id', 'mail_master_id');
    }
    

    protected $fillable = [ 
        'mail_master_id',
        'mail_content',
        'mail_from',
        'mail_title',
        'mail_body',
        'delete_flg',
        'updated_at',
        'created_at',
        
    ];
}
