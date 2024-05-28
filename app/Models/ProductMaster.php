<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    protected $table = 'product_master';
    protected $primaryKey = 'product_master_id';
    //use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    public function productDetailMaster()
    {
        return $this->hasMany(ProductDetailMaster::class, 'product_master_id', 'product_master_id');
    }
  

    public function productImageMaster()
    {
        return $this->hasManyThrough(
            'App\Models\ProductImageMaster',
            'App\Models\ProductDetailMaster',
            'product_master_id', // ProductDetailMaster での外部キー
            'product_id', // ProductImageMaster での外部キー
            'product_master_id', // ProductMaster のローカルキー
            'product_id'  // ProductDetailMaster のローカルキー
        );
    }

    protected $fillable = [ 
        'product_name',
        'brand',
        'category',
        'keywords',
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
