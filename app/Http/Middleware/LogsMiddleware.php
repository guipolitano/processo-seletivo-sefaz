<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;
use App\Models\Logs;

class LogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $data = $response->getData();

        if(isset($data->data)){
            if(is_array($data->data)){
                $gtin = $data->data[0]->COD_GTIN;
                $produtos = count($data->data);
            }else{
                $produtos = 1;
                $gtin = $data->data->COD_GTIN;
            }
        } else{
            $produtos = 0;
            $gtin = null;
        };

        $log = new Logs();
        $log->HORA = date('d/m/Y H:i:s');
        $log->COD_GTIN = $gtin;
        $log->STATUS_CODE = $response->status();
        $log->NUM_PRODUTOS = $produtos;
        $log->save();
    }
}
