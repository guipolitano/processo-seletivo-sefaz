<?php

namespace App\Http\Controllers;

use App\Http\Models\Produtos;

class ProdutosController extends Controller
{
    public function listarProdutos($gtin = null, $latitude = null, $longitude = null)
    {
        if ($gtin != null && $gtin != '') {
            try {
                $produtos = new Produtos();
                $data = $produtos->listarProdutos($gtin);

                if (!count($data)) {
                    return response()->json(['mensagem' => 'Nenhum produto cadastrado com esse GTIN!'], 400);
                }


                foreach ($data as $produto) {
                    //Adiciono a URL do Google Maps
                    $produto->LOCALIZACAO = 'http://maps.google.com/maps?q=' . $produto->NUM_LATITUDE . ',' . $produto->NUM_LONGITUDE;

                    //Adiciono a URL para o produto
                    $produto->URL = url('/api/v1/produto').'/'.$produto->ID;
                }

                //Adiciono a Distancia
                if (($latitude != null && $latitude != '') && ($longitude != null && $longitude != '')) {
                    foreach ($data as $produto) {
                        $produto->DISTANCIA = $this->calcularDistancia($produto->NUM_LATITUDE, $produto->NUM_LONGITUDE, $latitude, $longitude);
                    }
                }


                return response()->json(['mensagem' => 'Sucesso!', 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['erro' => $e->getMessage()]);
            }
        } else {
            return response()->json(['mensagem' => 'Erro 400 (Bad Request) - Deve-se incluir o GTIN!'], 400);
        }
    }

    public function mostrarProduto($id = null, $latitude = null, $longitude = null)
    {
        if ($id != null && $id != '') {
            try {
                $produtos = new Produtos();
                $data = $produtos->buscarProduto($id);

                if (!$data) {
                    return response()->json(['mensagem' => 'Nenhum produto cadastrado com esse ID!'], 400);
                }
                //Adiciono a URL do Google Maps
                $data->LOCALIZACAO = 'http://maps.google.com/maps?q=' . $data->NUM_LATITUDE . ',' . $data->NUM_LONGITUDE;

                //Adiciono a Distancia
                if (($latitude != null && $latitude != '') && ($longitude != null && $longitude != '')) {
                    $data->DISTANCIA = $this->calcularDistancia($data->NUM_LATITUDE, $data->NUM_LONGITUDE, $latitude, $longitude);
                }

                //Adiciono a URL para o produto
                $data->URL = url('/api/v1/produto').'/'.$data->ID;

                return response()->json(['mensagem' => 'Sucesso!', 'data' => $data]);
            } catch (\Exception $e) {
                return response()->json(['erro' => $e->getMessage()]);
            }
        } else {
            return response()->json(['mensagem' => 'Erro 400 (Bad Request) - Deve-se incluir o ID!'], 400);
        }
    }

    function calcularDistancia($latProd, $longProd, $latCli, $longCli)
    {
        // Este método utiliza a fórmula de Haversine para calcular a distancia entre dois pontos a partir de coordenadas geográficas
        $terra = 6371; //Considera o raio da terra como 6371 km

        //Converte de graus para radiano a distancia geográfica já subtraída
        $latFinal = deg2rad($latProd - $latCli);
        $lonFinal = deg2rad($longProd - $longCli);

        // Primeira parte: Seno da (lat/2)² + Cos da Latitude Inicial * Cos da Latitude Final * Seno da (long/2)²
        $p1 = sin($latFinal / 2) * sin($latFinal / 2) + cos(deg2rad($latCli)) * cos(deg2rad($latProd)) * sin($lonFinal / 2) * sin($lonFinal / 2);
        // Segunda parte: 2 * Seno do Arco de (√parte 1)
        $p2 = 2 * asin(sqrt($p1));
        // Resultado final é a parte 2 * o raio da terra
        $distancia = $terra * $p2;

        return round($distancia, 2) . ' KM';
    }
}
