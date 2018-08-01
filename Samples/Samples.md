# KRUD FrameWork Samples

KRUD é um mini framework PHP, para conexões rápidas com banco de dados via PDO, carregamento de configurações e autoload de classes.

Ele conta também com algumas classes que podem ajudar o desenvolvedor no seu dia a dia.

## Configurações para os exemplos

Para realizar seus teste você pode utilizar o banco de dados disponibilizado o projeto para teste.

```
bdsample.sql
```

### CreateSample

Realizando inserção no banco de dados

```
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
```

### ReadSample

Realizando leitura de dados no banco.

```
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
```

## UpdateSample

Realizando atualizações no banco de dados

```
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
```

## DeleteSample

Deletando registros no banco de dados

```
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
```

# Classes auxiliares

O KRUD vem com algumas classes que podem facilitar o seu dia a dia.

## Helpers - Classe Check.class.php

Faça o require do arquivo de configuração para inicializar o framework

```
 require 'app/config.krud.php';
```

Agora já podemos utilizar nossas classes auxiliares

Para utilizar a classes Check.class.php é simples:

```
Check::Funcao();
```

Segue abaixo todas as funções da classe Check:

```
Check::Name($string);
```

**_ Transforma URL: _** Tranforma uma string no formato de URL amigável e retorna o a string convertida!

```
Check::Data($data);
```

**_ Transforma Data: _** Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!

```
Check::Words($string, $limite, $pointer = null);
```

**_ Limita os Palavras: _** Limita a quantidade de palavras a serem exibidas em uma string!

```
Check::ValorTabela($tabela, $campo, $valor, $condicao = null);
```

**_ Buscar Valor no BD: _** Informe a tabela, o campo e o seu valor para saber se este já existe.

```
Check::DeletaArquivo($caminho);
```

**_ Deleta um arquivo: _** Informe o caminho do arquivo que deseja excluir.

```
Check::ConverterDecimal($valor);
```

**_ Converter um valor para decimal: _**

```
Check::ConverterMoedaBR(float $float);
```

**_ Converte para moeda BR: _**Converte um valor float para o formato de moeda BR.

```
Check::ValidaCNPJ($cnpj);
```

**_ Validar CNPJ: _** Verifica a validade do CNPJ informado.

```
Check::ValidaCPF($cpf);
```

**_ Validar CPF: _** Verifica a validade do CPF informado.

```
Check::ConverterDataBR($data);
```

**_ Converter data BR: _** Converte a data informada para o formato BR.

```
Check::ArredondarDizimasCentavos(float $valorIntegral, int $numParcelas);
```

**_ Arredonda dizimas: _** Responsável por arredondar dízimas de centavos, para evitar problemas em divisões.

```
Check::ConverterMesExtenso($mes);
```

**_ Converte o mês por extenso: _** Mostra o mês por extenso através de seu respectivo número.

## Email - Classe Email.class.php

Faça as configurações de e-mail no arquivo config.krud.php

Verifique as configurções fornecidas pelo empresa do seu fornecedora do seu e-mail

```
//DEFINE SERVIDOR DE EMAIL.
define('MAILUSER', 'usuario@krud.com');
define('MAILPASS', 'krud098');
define('MAILPORT', '587');
define('MAILHOST', 'smtp.dominio.com.br');
```

Faça o require do arquivo de configuração para inicializar o framework

```
 require 'app/config.krud.php';
```

Agora de forma bem simples apenas instancie a classe Email e Chame a função enviar, passando por parâmetro um array contendo as informações de envio

```
$data = [
        'assunto'=>'Assunto do email',
        'mensagem'=>'Mensagem do e-mail a ser enviado',
        'remetenteNome'=>'Nome de quem está enviando',
        'remetenteEmail'=>'E-mail de quem está enviando',
        'destinoNome'=>'E-mail nome de quem vai receber',
        'destinoEmail'=>'E-mail de quem está recebendo'];
$email = new Email;
$email->Enviar($data);
```

Simples assim :)

## Upload - Classe Upload.class.php

Faça as configurações de e-mail no arquivo config.krud.php

Faça o require do arquivo de configuração para inicializar o framework

```
 require 'app/config.krud.php';
```

Para começar a utilizar a Classe Upload apenas instancie a classe e chame suas funções.

```
...
...

$upload = new Upload;

...
...
```

Segue abaixo a lista de funções

```
 * @param FILES $Image = Enviar envelope de $_FILES (JPG ou PNG)

$upload->Image(array $Image, $Name = null, $Width = null, $Folder = null)
```

**_ Realiza o upload de uma imagem: _** Envia uma imagem para o servidor.

```
 * @param FILES $File = Enviar envelope de $_FILES (PDF ou DOCX)

$upload->File(array $File, $Name = null, $Folder = null, $MaxFileSize = null);
```

**_ Realiza o upload de um arquivo: _** Envia um arquivo para o servidor.

```
 * @param FILES $Media = Enviar envelope de $_FILES (MP3 ou MP4)

$upload->Media(array $Media, $Name = null, $Folder = null, $MaxFileSize = null);
```

**_ Realiza o upload de mídias: _** Envia uma mídia para o servidor.

```
$upload->getResult();
```

**_ Resultado das funções: _** Essa função retorna se as funções de upload retornaram true (Para sucesso) ou false(Falha).

```
$upload->getError();
```

**_ Retorno de erros: _** Essa função retorna as informações de erro das funções de upload.
