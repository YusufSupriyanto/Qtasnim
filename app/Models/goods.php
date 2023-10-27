<?php

namespace App\Models;


use App\Models\types_goods;
use App\Models\transactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class goods extends Model
{
    use HasFactory;
    protected $fillable = ['good_name', 'types_goods_id'];
    public function transaction()
    {
        return $this->hasMany(transactions::class, 'goods_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(types_goods::class, 'types_good_id', 'id');
    }
}