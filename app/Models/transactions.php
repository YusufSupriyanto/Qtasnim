<?php

namespace App\Models;


use App\Models\goods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class transactions extends Model
{
    use HasFactory;

    protected $fillable = ['goods_id', 'quantity_sold', 'date_transaction'];

    public function goods()
    {
        return $this->belongsTo(goods::class, 'goods_id', 'id');
    }

    public  function allTransaction()
    {
        return $this->select('transactions.*', 'goods.good_name', 'types_goods.good_type')
            ->leftJoin('goods', 'goods.id', '=', 'transactions.goods_id')
            ->leftJoin('types_goods', 'goods.types_goods_id', '=', 'types_goods.id')
            ->get();
    }

    public function search($searchTerm)
    {
        return $this->select('transactions.*', 'goods.good_name', 'types_goods.good_type')
            ->leftJoin('goods', 'goods.id', '=', 'transactions.goods_id')
            ->leftJoin('types_goods', 'goods.types_goods_id', '=', 'types_goods.id')
            ->where(function ($query) use ($searchTerm) {
                $query->where('goods.good_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('transactions.date_transaction', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    }

    public function filterUp($startDate, $endDate)
    {
        return $this->select('transactions.*', 'goods.good_name', 'types_goods.good_type')
            ->leftJoin('goods', 'goods.id', '=', 'transactions.goods_id')
            ->leftJoin('types_goods', 'goods.types_goods_id', '=', 'types_goods.id')
            ->whereBetween('transactions.date_transaction', [$startDate, $endDate])
            ->orderBy('transactions.quantity_sold', 'desc')
            ->get();
    }

    public function filterDown($startDate, $endDate)
    {
        return $this->select('transactions.*', 'goods.good_name', 'types_goods.good_type')
            ->leftJoin('goods', 'goods.id', '=', 'transactions.goods_id')
            ->leftJoin('types_goods', 'goods.types_goods_id', '=', 'types_goods.id')
            ->whereBetween('transactions.date_transaction', [$startDate, $endDate])
            ->orderBy('transactions.quantity_sold', 'asc')
            ->get();
    }
}
