<?php

/**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @copyright (c) 2018, Kaique R. Correia.
 */
class Check {

    private static $Data;
    private static $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public static function Email($Email) {
        self::$Data = (string) $Email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
    public static function Name($Name) {
        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        self::$Data = strip_tags(trim(self::$Data));
        self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

        return strtolower(utf8_encode(self::$Data));
    }

    /**
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function Data($Data) {
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        if (empty(self::$Format[1])):
            self::$Format[1] = date('H:i:s');
        endif;

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        return self::$Data;
    }

    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public static function Words($String, $Limite, $Pointer = null) {
        self::$Data = strip_tags(trim($String));
        self::$Format = (int) $Limite;

        $ArrWords = explode(' ', self::$Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, self::$Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer);
        $Result = (self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data);
        return $Result;
    }

    /**
     * <b>Buscar Valor no BD:</b> Informe a tabela, o campo e o seu valor para saber se este ja existe.
     * @param STRING $tabela = tabela do bd
     * @param STRING $campo = campo da tabela
     * @param STRING $valor = valor do campo
     * @return BOOL
     */
    public static function ValorTabela($tabela, $campo, $valor, $condicao = null) {
        $read = new Read;
        $read->ExeRead("{$tabela}", "WHERE {$campo} = :valor {$condicao}", "valor={$valor}");
        if ($read->getRowCount()):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Responsável por deletar um arquivo</b>. Informe o caminho do arquivo que deseja excluir.
     * @param STRING $caminho = caminho do arquivo no servidor.
     * @return BOOL
     */
    public static function DeletaArquivo($caminho) {
        if (!unlink($caminho)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * <b>Converter um valor para decimal</b>.
     * @param STRING $valor = valor a ser convertido para número decimal.
     * @return BOOL
     */
    public static function ConverterDecimal($valor) {
        if ($valor) {
            $valorConvertido = str_replace(',', '.', str_replace('.', '', $valor));
            return floatval($valorConvertido);
        } else {
            return 0;
        }
    }
    /**
     * <b>Converte para moeda BR:</b> Converte um valor float para o formato de moeda BR.
     * @param STRING $valor = valor a ser convertido para moeda BR.
     * @return FLOAT
     */
    public static function ConverterMoedaBR(float $float) {
        if ($float) {
            $valorConvertido = number_format($float, 2, ',', '.');
            return $valorConvertido;
        } else {
            return 0;
        }
    }
    /**
     * <b>Validar CNPJ:</b> Verifica a validade do cnpj informado.
     * @param STRING $cnpj = cnpj informado.
     * @return BOOL
     */
    public static function valida_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * <b>Validar CPF:</b> Verifica a validade do CPF informado.
     * @param STRING $cpf = cpf informado.
     * @return BOOL
     */
    public static function ValidaCPF($cpf = false) {

        if (!function_exists('calc_digitos_posicoes')) {

            function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0) {
                // Faz a soma dos digitos com a posição
                // Ex. para 10 posições:
                //   0    2    5    4    6    2    8    8   4
                // x10   x9   x8   x7   x6   x5   x4   x3  x2
                // 	 0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
                for ($i = 0; $i < strlen($digitos); $i++) {
                    $soma_digitos = $soma_digitos + ($digitos[$i] * $posicoes);
                    $posicoes--;
                }

                // Captura o resto da divisão entre $soma_digitos dividido por 11
                // Ex.: 196 % 11 = 9
                $soma_digitos = $soma_digitos % 11;

                // Verifica se $soma_digitos é menor que 2
                if ($soma_digitos < 2) {
                    // $soma_digitos agora será zero
                    $soma_digitos = 0;
                } else {
                    // Se for maior que 2, o resultado é 11 menos $soma_digitos
                    // Ex.: 11 - 9 = 2
                    // Nosso dígito procurado é 2
                    $soma_digitos = 11 - $soma_digitos;
                }

                // Concatena mais um digito aos primeiro nove digitos
                // Ex.: 025462884 + 2 = 0254628842
                $cpf = $digitos . $soma_digitos;

                // Retorna
                return $cpf;
            }

        }

        // Verifica se o CPF foi enviado
        if (!$cpf) {
            return false;
        }

        // Remove tudo que não é número do CPF
        // Ex.: 025.462.884-23 = 02546288423
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se o CPF tem 11 caracteres
        // Ex.: 02546288423 = 11 números
        if (strlen($cpf) != 11) {
            return false;
        }

        // Captura os 9 primeiros dígitos do CPF
        // Ex.: 02546288423 = 025462884
        $digitos = substr($cpf, 0, 9);

        // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
        $novo_cpf = calc_digitos_posicoes($digitos);

        // Faz o cálculo dos 10 digitos do CPF para obter o último dígito
        $novo_cpf = calc_digitos_posicoes($novo_cpf, 11);

        // Verifica se o novo CPF gerado é identico ao CPF enviado
        if ($novo_cpf === $cpf) {
            // CPF válido
            return true;
        } else {
            // CPF inválido
            return false;
        }
    }

    /**
     * <b>Converter data BR:</b> Converte a data informada para o formato BR.
     * @param STRING $data = data a ser convertida.
     * @return DATE
     */

    public static function ConverterDataBR($data) {

        $dataConvertida = date('d/m/Y', strtotime($data));
        return $dataConvertida;
    }

    /**
     * <b>Arredonda dizimas:</b> Responsável por arredondar dízimas de centavos, para evitar problemas em divisões.
     * @param FLOAT $valorIntegral = valor total a ser dividido.
     * @param INT $numParcelas = Quantidade de parcelas para dividir o valor integral.
     * @return FLOAT
     */

    public static function ArredondarDizimasCentavos(float $valorIntegral, int $numParcelas) {
        if ($valorIntegral > 0):
            $total_pagamento = $valorIntegral;
            $parcelas = $numParcelas;
            $valor_quebrado = round(($total_pagamento / $parcelas), 2);
            $valor_quebrado_total = round($total_pagamento - ($valor_quebrado * $parcelas), 2);

            for ($i = 1; $i <= $parcelas; $i++) {
                if ($i == $parcelas)
                    $valor_quebrado = $valor_quebrado + $valor_quebrado_total;
                $valor_parcelas[$i] = $valor_quebrado;
            }
            return $valor_parcelas;
        endif;
    }

    /**
     * <b>Converte o mês por extenso:</b> Mostra o mês por extenso através de seu respectivo número.
     * @param STRING $mes = mes informado.
     * @return STRING
     */
    public static function ConverterMesExtenso($mes) {
        switch ($mes) {
            case "01": $mes = 'Janeiro';
                break;
            case "02": $mes = 'Fevereiro';
                break;
            case "03": $mes = 'Março';
                break;
            case "04": $mes = 'Abril';
                break;
            case "05": $mes = 'Maio';
                break;
            case "06": $mes = 'Junho';
                break;
            case "07": $mes = 'Julho';
                break;
            case "08": $mes = 'Agosto';
                break;
            case "09": $mes = 'Setembro';
                break;
            case "10": $mes = 'Outubro';
                break;
            case "11": $mes = 'Novembro';
                break;
            case "12": $mes = 'Dezembro';
                break;
        }
        return $mes;
    }

}
