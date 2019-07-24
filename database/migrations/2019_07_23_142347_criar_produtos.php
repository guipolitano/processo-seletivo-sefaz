<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function ($table) {
            $table->increments('ID');
            $table->string('COD_GTIN');
            $table->string('DAT_EMISSAO');
            $table->string('COD_TIPO_PAGAMENTO');
            $table->string('COD_PRODUTO');
            $table->string('COD_NCM');
            $table->string('COD_UNIDADE');
            $table->string('DSC_PRODUTO');
            $table->string('VLR_UNITARIO');
            $table->string('ID_ESTABELECIMENTO');
            $table->string('NME_ESTABELECIMENTO');
            $table->string('NME_LOGRADOURO');
            $table->string('COD_NUMERO_LOGRADOURO');
            $table->string('NME_COMPLEMENTO');
            $table->string('NME_BAIRRO');
            $table->string('COD_MUNICIPIO_IBGE');
            $table->string('NME_MUNICIPIO');
            $table->string('NME_SIGLA_UF');
            $table->string('COD_CEP');
            $table->string('NUM_LATITUDE');
            $table->string('NUM_LONGITUDE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
