<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCodeMaster extends Model
{
    protected $table = 'postcode_master';
    //use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // CityMaster モデルとのリレーション
    public function city()
    {
        return $this->belongsTo(CityMaster::class, 'city_code', 'city_code');
    }
    public function prefecture()
    {
        return $this->belongsTo(PrefectureMaster::class, 'prefecture_code', 'prefecture_code');
    }
    protected $fillable = [
        'post_master_id',
        'post_code',
        'prefecture_code',
        'city_code',
        'region_name',
        'block_number',
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
