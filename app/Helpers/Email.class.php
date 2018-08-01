<?php

require('_app/Library/PHPMailer/phpmailer.class.php');
require ('_app/Library/PHPMailer/smtp.class.php');

/**
 * Email [ MODEL ]
 * Modelo responsável por configurar o PHPMailer, validar os dados e disparar e-mails do sistema.
 * @copyright (c) 2018, Kaique R. Correia.
 */
class Email {

    /** @var PHPMailer */
    private $mail;

    /** Email data */
    private $data;

    /** CORPO DO EMAIL */
    private $assunto;
    private $mensagem;

    /** REMETENTE */
    private $remetenteNome;
    private $remetenteEmail;

    /** DESTINO */
    private $destinoNome;
    private $destinoEmail;

    /** CONTROLE */
    private $error;
    private $result;

    function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->Host = MAILHOST;
        $this->mail->Port = MAILPORT;
        $this->mail->Username = MAILUSER;
        $this->mail->Password = MAILPASS;
        $this->mail->CharSet = 'UTF-8';
    }

    public function Enviar(array $data) {
        $this->data = $data;
        $this->Clear();

        if (in_array('', $this->data)):

            $this->error = ['Erro ao enviar mensagem: Para enviar esse e-mail. Preencha todos os campos requisistados', WS_ALERT];
            $this->result = false;

        elseif (!Check::Email($this->data['remetenteEmail'])):
            $this->error = ['Erro ao enviar mensagem: O email que você informou não tem formato válido. Informe Novamente!', WS_ERROR];
            $this->result = false;
        else:
            $this->setMail();
            $this->setConfig();
            $this->sendMail();
        endif;
    }

    function getResult() {
        return $this->result;
    }

    function getError() {
        return $this->error;
    }

    //PRIVATE
    private function Clear() {
        array_map('strip_tags', $this->data);
        array_map('trim', $this->data);
    }

    private function setMail() {
        $this->assunto = $this->data['assunto'];
        $this->mensagem = $this->data['mensagem'];
        $this->remetenteNome = $this->data['remetenteNome'];
        $this->remetenteEmail = $this->data['remetenteEmail'];
        $this->destinoNome = $this->data['destinoNome'];
        $this->destinoEmail = $this->data['destinoEmail'];

        $this->data = null;
        $this->setMsg();
    }

    private function setMsg() {
        $this->mensagem = "{$this->mensagem}<hr><small>Recebida em: " . date('d/m/Y H:i') . "</small>";
    }

    private function setConfig() {
        //SMTP AUTH
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->isHTML();

        //REMETENTE E RETORNO
        $this->mail->From = MAILUSER;
        $this->mail->FromName = $this->remetenteNome;
        $this->mail->addReplyTo($this->remetenteEmail, $this->remetenteNome);

        //ASSUNTO, MENSAGEM E DESTINO
        $this->mail->Subject = $this->assunto;
        $this->mail->Body = $this->mensagem;
        $this->mail->addAddress($this->destinoEmail, $this->destinoNome);
    }

    private function sendMail() {
        if ($this->mail->send()):
            $this->error = ['Obrigado por entrar em contato: recebemos sua mensagem e estaremos recebendo em breve!', WS_ACCEPT];
            $this->result = true;
        else:
            $this->error = ["Erro ao enviar: Entre em contato com o admin. ( {$this->mail->ErrorInfo} )", WS_ERROR];
            $this->result = true;
        endif;
    }

}
