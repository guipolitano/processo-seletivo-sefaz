## Informações do Projeto
### Projeto criado para processo seletivo 2019 da Sefaz;
### O objetivo do projeto é construir uma API para consulta e recuperação de uma lista de produtos.
## Tecnologias Utilizadas
- PHP com framework Laravel (versão 5.8.29)
- Banco em Sqlite

## Configurações Iniciais
1) No arquivo .env altere o 'DB_DATABASE=' para o caminho absoluto de seu arquivo 'database.sqlite';
2) Em seu terminal e na raiz do projeto utilize o comando 'php artisan migrate';
3) O banco é montado através do CSV da pasta '/public/imports/', por isso, certifique que o arquivo .csv encontra-se lá;
4) Em seu terminal e na raiz do projeto utilize o comando 'php artisan serve' para executar o projeto;

## Importando o banco
1) Para importar o arquivo .csv acesse a rota '/api/v1/importar/dataset.csv', caso deseje importar um novo banco, basta alterar o 'dataset' para o nome do novo arquivo. Mas certifique-se de que as colunas sejam as mesmas;

## Buscando os produtos por GTIN
1) Para buscar os produtos através do código GTIN utilize a rota '/api/v1/produtos/{cod-gtin}' substituindo 'cod-gtin' pelo produto a ser encontrado. Ex.: /api/v1/produtos/7893000394117;
2) Caso deseje buscar a distancia de sua localização até o produto basta incluir a sua latitude e longitude conforme se segue: '/api/v1/produtos/{cod-gtin}/{lat},{log}' lembrando de separar por vírgula as coordenadas. Ex.: '/api/v1/produtos/7893000394117/-20.2954483,-40.3073157';

## Buscando os produtos pelo ID
1) Ao importar o banco de dados é atribuído para cada produto um ID único, através deste ID é possível buscar o produto. Para fazer isso basta inserir o ID do produto na rota '/api/v1/produto/{id}'. Para evitar erros, atente-se para o 'produto' no singular. Ex.: '/api/v1/produto/58';
2) Da mesma forma que é possível buscar a distancia de todos os produtos, é possível buscar a distância deste produto em específico, bastando adicionar as suas coordenadas de latitude e longitude na rota '/api/v1/produto/{id}/{lat},{log}'. Ex.: '/api/v1/produto/58/-20.2954483,-40.3073157'

### Autor: Guilherme Politano de Sant' Anna
