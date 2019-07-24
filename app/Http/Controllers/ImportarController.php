<?php

namespace App\Http\Controllers;

use App\Http\Models\Produtos;
use Illuminate\Support\Facades\DB;

class ImportarController extends Controller
{
    public function index($nomeArquivo)
    {
        try {
            ini_set('max_execution_time', 180); //Atribui o tempo máximo de execução da query para 3min, vez que o volume de dados é bem grande.
            DB::beginTransaction();
            if($nomeArquivo != 'test.csv'){
                DB::table('produtos')->delete(); //Limpa a tabela para inclusão de novos registros
            }

            $arquivo = public_path('imports/' . $nomeArquivo);

            if (!file_exists($arquivo) || !is_readable($arquivo))
                return response()->json(['mensagem' => "Não foi possível ler o arquivo. Certifique-se que ele esteja no formato .csv e na pasta '/public/imports'. Na url o arquivo deve ser digitado com a extensão .csv."]);

            if (($handle = fopen($arquivo, 'r')) !== FALSE) {
                fgetcsv($handle, 10000, ","); //Pula a primeira linha (que contém as colunas)
                while (($data = fgetcsv($handle, 10000, ',')) !== FALSE) {
                    $produto = new Produtos();
                    $produto->COD_GTIN = $data[0];
                    $produto->DAT_EMISSAO = $data[1];
                    $produto->COD_TIPO_PAGAMENTO = $data[2];
                    $produto->COD_PRODUTO = $data[3];
                    $produto->COD_NCM = $data[4];
                    $produto->COD_UNIDADE = $data[5];
                    $produto->DSC_PRODUTO = $data[6];
                    $produto->VLR_UNITARIO = $data[7];
                    $produto->ID_ESTABELECIMENTO = $data[8];
                    $produto->NME_ESTABELECIMENTO = $data[9];
                    $produto->NME_LOGRADOURO = $data[10];
                    $produto->COD_NUMERO_LOGRADOURO = $data[11];
                    $produto->NME_COMPLEMENTO = $data[12];
                    $produto->NME_BAIRRO = $data[13];
                    $produto->COD_MUNICIPIO_IBGE = $data[14];
                    $produto->NME_MUNICIPIO = $data[15];
                    $produto->NME_SIGLA_UF = $data[16];
                    $produto->COD_CEP = $data[17];
                    $produto->NUM_LATITUDE = $data[18];
                    $produto->NUM_LONGITUDE = $data[19];
                    $produto->save();
                }
                fclose($handle);

                if($nomeArquivo != 'test.csv'){
                    DB::commit();
                }
                return response()->json(['mensagem' => 'Dados importados com sucesso!'], 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensagem' => 'Ocorreu um erro!' , 'erro' => $e]);
        }
    }
}
