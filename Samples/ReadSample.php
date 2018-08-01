<?php
/** 
 * @copyright (c) 2018, Kaique R. Correia.
 * 
 * Exemplo de leitura em uma base de dados.
 * Aqui é esperado que as configurações do banco de dados já foram inseridas no arquivo config.krud.php 
 * Para testar os exemplos é necessário que as tabelas estejam populadas
 * para retornar corretamente as informações.
 * Para realizar os exemplos você utilizar o banco que "bdsample".
*/


//Inclui o krud no projeto
require '../app/Config.krud.php';


/**
 * Leitura simples de todas as linhas da tabela
 */
echo "Leitura simples </br>";

//Instância da classe Read
$read = new Read;
//Informar nome da tabela
$read->ExeRead('book');
//getResult() retorna os dados em formato de array ou false me caso de falha
if ($read->getResult()) {
    foreach ($read->getResult() as $book) {
        echo "Livro ID: {$book['id']} - Descrição: {$book['descricao']} - Autor: {$book['autor']} </br>";
    }
}

echo "</br></br> Leitura condicionada </br>";

/**
 * Leitura com condicionada 
 */

//Instância da classe Read
$read = new Read;
//Informar nome da tabela
$read->ExeRead('book','order by id desc');
//getResult() retorna os dados em formato de array ou false me caso de falha
if ($read->getResult()) {
    foreach ($read->getResult() as $book) {
        echo "Livro ID: {$book['id']} - Descrição: {$book['descricao']} - Autor: {$book['autor']} </br>";
    }
}


echo "</br></br> Leitura condicionada com um ou mais parâmetros</br>";

/**
 * Leitura com condicionada com mais de um parâmetro (parsestrings).
 * Prevenção de  SQL INJECTION
 */

 //Id externo vindo de um front
$id_book1 = 1;
$id_book2 = 3;

//Instância da classe Read
$read = new Read;
//Informar nome da tabela
$read->ExeRead('book','WHERE id = :id_book1 OR id = :id_book2 ', "id_book1={$id_book1}&id_book2={$id_book2}");
//getResult() retorna os dados em formato de array ou false me caso de falha
if ($read->getResult()) {
    foreach ($read->getResult() as $book) {
        echo "Livro ID: {$book['id']} - Descrição: {$book['descricao']} - Autor: {$book['autor']} </br>";
    }
}

/**
 * Quantidade de linhas retornadas do banco
 */
echo "</br></br>Quantidade de linhas retornadas do banco </br>";

//Instância da classe Read
$read = new Read;
//Informar nome da tabela
$read->ExeRead('book');
//getResult() retorna os dados em formato de array ou false me caso de falha
if ($read->getResult()) {
    foreach ($read->getResult() as $book) {
        echo "Livro ID: {$book['id']} - Descrição: {$book['descricao']} - Autor: {$book['autor']} </br>";
    }
    $linhas = $read->getRowCount();
    echo "Número de linhas retornadas : {$linhas}";
}