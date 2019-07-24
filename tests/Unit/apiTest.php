<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Models\Produtos;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class apiTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    //Testes de acerto
    public function testeInsercaoCsv(){
        $nomeArquivo = 'test.csv';
        $response = $this->json('GET', '/api/v1/importar/' . $nomeArquivo);
        $response->assertStatus(201);
    }

    public function testeGetProdutosGtin()
    {
        $produtos = new Produtos();
        $data = $produtos->testarProdutos();

        foreach ($data as $produto) {
            $response = $this->json('GET', '/api/v1/produtos/' . $produto->COD_GTIN);
            $response->assertStatus(200);
        }
    }

    public function testeGetProdutosLatLog()
    {
        $produtos = new Produtos();
        $data = $produtos->testarProdutos();

        foreach ($data as $produto) {
            $response = $this->json('GET', '/api/v1/produtos/' . $produto->COD_GTIN . '/-20.2809816,-40.297479');
            $response->assertStatus(200);
        }
    }

    public function testeGetProdutoId()
    {
        $produtos = new Produtos();
        $data = $produtos->testarProdutos();

        foreach ($data as $produto) {
            $response = $this->json('GET', '/api/v1/produto/' . $produto->ID);
            $response->assertStatus(200);
        }
    }

    public function testeGetProdutoIdLatLog()
    {
        $produtos = new Produtos();
        $data = $produtos->testarProdutos();

        foreach ($data as $produto) {
            $response = $this->json('GET', '/api/v1/produto/' . $produto->ID . '/-20.2809816,-40.297479');
            $response->assertStatus(200);
        }
    }

    //Testes de erros
    public function testeGetProdutosSemGtin()
    {
        $gtin = '';
        $response = $this->json('GET', '/api/v1/produtos/' . $gtin);
        $response->assertStatus(400);
    }

    public function testeGetProdutosGtinErrado()
    {
        $gtin = '8786577';
        $response = $this->json('GET', '/api/v1/produtos/' . $gtin);
        $response->assertStatus(400);
    }

    public function testeGetProdutoSemId()
    {
        $id = '';
        $response = $this->json('GET', '/api/v1/produto/' . $id);
        $response->assertStatus(400);
    }

    public function testeGetProdutosIdErrado()
    {
        $id = '8786572337';
        $response = $this->json('GET', '/api/v1/produto/' . $id);
        $response->assertStatus(400);
    }
}
