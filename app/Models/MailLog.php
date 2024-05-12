<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    use HasFactory;

    protected $table = 'mail_log';
    protected $primaryKey = 'mail_log_id';


    public function mail_master()
    {
        return $this->belongsTo(MailMaster::class, 'mail_master_id', 'mail_master_id');
    }
    
    protected $fillable = [ 
        'mail_log_id',
        'mail_master_id',
        'order_id',
        'mail_from',
        'mail_to',
        'mail_title',
        'mail_body',
        'sent_at',
        'submit_result',
        'delete_flg',
        'updated_at',
        'created_at',
    ];
    
}
