<?php
/** 
 * @copyright (c) 2018, Kaique R. Correia.
 * 
 * Exemplo de atualização em uma base de dados.
 * Aqui é esperado que as configurações do banco de dados já foram inseridas no arquivo config.krud.php.
 * Para realizar os exemplos você utilizar o banco que "bdsample".  
 */


// Inclui o krud no projeto
require '../app/Config.krud.php';

// Dados a serem atualizados no banco. Os indices do array deve conter o mesmo nome do campo na tabela
// É necessário passar apenas os campos que serão atualizados.

$data = ['autor'=> 'Correia K. Kaique'];
$primeiro = 1;
$segundo = 2;
//Instância da classe Update
$update = new Update;

//Informar nome da tabela, o array de dados, os termos de condição e parserstrings.
$update->ExeUpdate('book',$data,'WHERE id = :primeiro OR id = :segundo',"primeiro={$primeiro}&segundo={$segundo}");

//O método getResult() retorna o true ou 1 em caso de sucesso, mesmo que não tenho realizado nenhuma alteração.
echo "O método getResult() retorna o true ou 1 em caso de sucesso, mesmo que não tenho realizado nenhuma alteração</br>";
if ($update->getResult()) {
    $retorno = $update->getResult();
    echo "</br>Book atualizado ";
    echo"Retorno de getResult(): {$retorno} </br>";

    //Para saber se ocorreu uma atualização de fato na tabela execute getRowCount().
    //Ele retorna a quantidade de linhas que foram alteradas na tabela.
    echo"</br>Veja o retorno da função getRowCount para saber a quantidade de alteração</br>";
    $result = $update->getRowCount();
    echo"Retorno de getRowCount() : {$result}";

}else{
    echo "Ocorreu uma falha durante a atualização dos dados";
}
