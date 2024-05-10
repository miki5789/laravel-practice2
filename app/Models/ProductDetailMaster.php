<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailMaster extends Model
{
    protected $table = 'product_detail_master';
    protected $primaryKey = 'product_id';
    //use HasApiTokens, HasFactory, Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function productImageMaster()
    {
        return $this->hasMany(ProductImageMaster::class, 'product_id', 'product_id');
    }
    
    public function productMaster()
    {
        return $this->belongsTo(ProductMaster::class, 'product_master_id', 'product_master_id');
    }

    protected $fillable = [
        'product_id',
        'color',
        'price',
        'quantity',
        'product_master_id',
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
