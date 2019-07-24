<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produtos extends Model
{
    protected $table = 'produtos';
    public $timestamps = false;

    function listarProdutos($gtin)
    {
        $produtos = DB::table('produtos')
            ->select('*')
            ->where([
                ['COD_GTIN', '=', $gtin],
                ['VLR_UNITARIO', '>', '0'],
                ['VLR_UNITARIO', '<>', ''],
                ['NUM_LATITUDE', '<>', ''],
                ['NUM_LONGITUDE', '<>', '']
            ])
            ->orderBy('VLR_UNITARIO')
            ->get();
        return $produtos;
    }

    function buscarProduto($id)
    {
        $produto = DB::table('produtos')
            ->select('*')
            ->where('ID', '=', $id)
            ->first();
        return $produto;
    }

    function testarProdutos()
    {
        $produto = DB::table('produtos')
            ->select('*')
            ->limit(20)
            ->where([
                ['VLR_UNITARIO', '>', '0'],
                ['VLR_UNITARIO', '<>', ''],
                ['NUM_LATITUDE', '<>', ''],
                ['NUM_LONGITUDE', '<>', '']
            ])
            ->get();
        return $produto;
    }
}
