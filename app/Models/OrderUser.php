<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    protected $table = 'order_user';
    /// 主キーカラム名を指定
    protected $primaryKey = 'order_id';
    
    //use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [ 
        'order_id',
        'total_price',
        'surname',
        'given_name',
        'surname_kana',
        'given_name_kana',
        'post_code',
        'prefecture',
        'address',
        'mail',
        'order_date',
        'delete_flg',
        'updated_at',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        //'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        //'password' => 'hashed',
    ];
}
