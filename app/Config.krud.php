<?php
/** 
 * @copyright (c) 2018, Kaique R. Correia.
*/

// CONFIGURAÇÃO DO BANCO DE DADOS.
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBSA', 'test');

# AQUI PODEM SER DEFINIDAS CONSTANTES QUE CARREGARAM JUNTO COM O  PROJETO.


//DEFINE SERVIDOR DE EMAIL.
define('MAILUSER', '');
define('MAILPASS', '');
define('MAILPORT', '');
define('MAILHOST', '');

//DEFINE IDENTIDADE DO PROJETO.
define('SITENAME', 'KRUD');
define('SITEDESC', 'KRUD MINI-FRAMEWORK');

//DEFINE A BASE DO SITE.
define('HOME', 'http://localhost/krud/');

// AUTO LOAD DE CLASSES.
function AutoLoader($Class) {

    /**
     * DEFINA ABAIXO AS PASTAS DENTRO DE "_app" QUE SERÃO INCLUÍDAS NO AUTOLOAD.
     */
    $cDir = ['Conn', 'Helpers', "Library"];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php") && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php")):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;
    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

spl_autoload_register('AutoLoader');

// TRATAMENTO DE ERROS.

//CSS constantes :: Mensagens de Erro.

//KRUDErro :: Exibe erros lançados :: Front.
function KRUDErro($ErrMsg, $ErrNo, $ErrDie = null) {
    echo "<p >{$ErrMsg}<span></span></p>";

    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP.s
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    echo "<p>";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span ></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');

