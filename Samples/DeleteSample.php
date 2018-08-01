<?php
/** 
 * @copyright (c) 2018, Kaique R. Correia.
 * 
 * Exemplo de delete em uma base de dados.
 * Aqui é esperado que as configurações do banco de dados já foram inseridas no arquivo config.krud.php.
 * Para realizar os exemplos você utilizar o banco que "bdsample". 
*/


//Inclui o krud no projeto
require '../app/Config.krud.php';

//Dados a serem deletados no banco. Informe o ID que deseja excluir

$id = 1;

//Instância da classe Create
$delete = new Delete;
//Informar nome da tabela, os termos e os parâmetros
$delete->ExeDelete('book','WHERE id = :id', "id={$id}");
//O método getResult() retorna o true ou 1 em caso de sucesso ou false em caso de erro.
if ($delete->getResult()) {
    $result = $delete->getResult();
    echo "Registro excluído com sucesso!";

    //Para saber se ocorreu uma exclusão de fato na tabela execute getRowCount().
    //Ele retorna a quantidade de linhas que foram excluídas na tabela.
    echo"</br></br>Veja o retorno da função getRowCount para saber a quantidade de exclusões</br>";
    $result = $delete->getRowCount();
    echo"Retorno de getRowCount() : {$result}";
}else{
    echo "Ocorreu uma falha durante a exclusão dos dados";
}