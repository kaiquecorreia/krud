<?php
/** 
 * @copyright (c) 2018, Kaique R. Correia.
 * 
 * Exemplo de inserção em uma base de dados.
 * Aqui é esperado que as configurações do banco de dados já foram inseridas no arquivo config.krud.php.
 * Para realizar os exemplos você utilizar o banco que "bdsample".
 *  
*/


//Inclui o krud no projeto
require '../app/Config.krud.php';

//Dados a serem inseridos no banco. Os indices do array deve conter o mesmo nome do campo na tabela

$data = ['descricao'=> 'Krud FrameWork', 'autor'=>'Kaique R. Correia'];

//Instância da classe Create
$create = new Create;
//Informar nome da tabela o o array de dados
$create->ExeCreate('book',$data);
//O método getResult() retorna o ID em caso de sucesso ou false em caso de erro.
if ($create->getResult()) {
    $id = $create->getResult();
    echo "O ID inserido foi :{$id}";
}else{
    echo "Ocorreu uma falha durante a inserção dos dados";
}