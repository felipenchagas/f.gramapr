<?php
// Inclui o arquivo class.phpmailer.php localizado na pasta class
require_once("novo/class.phpmailer.php");
// Inicia a classe PHPMailer
$mail = new PHPMailer(true);
// Define os dados do servidor e tipo de conex�o
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem ser� SMTP
$mail->CharSet = 'UTF-8';
// Dados Formul�rio

    $nomeremetente = $_POST['nomeremetente'];
    $emailremetente = $_POST['emailremetente'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $ddd = $_POST['ddd'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

	

function GerarOrcamento(){

    $arquivo = "orcamentos.txt";   
    $abrir = fopen($arquivo, 'r+') or die("O txt nao pode ser aberto.");   
    $contador = fread($abrir, filesize($arquivo));   
    $intcontador = (int) $contador;   
    $intcontador++;   
    rewind($abrir);   
    fwrite($abrir, $intcontador);   
    fclose($abrir);   
    return $intcontador;  

    }

    $orcamento = GerarOrcamento();
  
try {
     $mail->IsSMTP(); /* Ativar SMTP*/
     $mail->Host = 'mail.gramasinteticapr.com.br'; // Endere�o do servidor SMTP (Autentica��o, utilize o host smtp.seudom�nio.com)
     $mail->SMTPAuth   = true;  // Usar autentica��o SMTP (obrigat�rio para smtp.seudom�nio.com)
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = 'contato@gramasinteticapr.com.br'; // Usu�rio do servidor SMTP (endere�o de email)
     $mail->Password = 'Futgrass80802!'; // Senha do servidor SMTP (senha do email usado)
$mail->AddAddress('contato@gramasinteticapr.com.br', 'gramasinteticapr');
     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom('contato@gramasinteticapr.com.br', "$nomeremetente"); //Seu e-mail
     $mail->AddReplyTo('contato@gramasinteticapr.com.br', 'Nome'); //Seu e-mail	
    $mail->Subject = "OR�AMENTO - SITE - # $orcamento";//Assunto do e-mail
    $mail->isHTML(true);
	
	
         
    //Campos abaixo s�o opcionais 
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //$mail->AddCC('destinarario@dominio.com', 'Destinatario'); // Copia
    //$mail->AddBCC('destinatario_oculto@dominio.com', 'Destinatario2`'); // C�pia Oculta
    //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo 
    //Define o corpo do email

    $message = file_get_contents('form.html'); 
       
    $message = str_replace('%orcamento%', $orcamento, $message); 
    $message = str_replace('%nome%',$nomeremetente, $message); 
    $message = str_replace('%telefone%', '('.$ddd.') '.$telefone, $message); 
    $message = str_replace('%cidade%', $cidade, $message);
    $message = str_replace('%email%', $emailremetente, $message); 
    $message = str_replace('%mensagem%', $mensagem, $message);  
	
    $mail->MsgHTML($message);  


    ////Caso queira colocar o conteudo de um arquivo utilize o m�todo abaixo ao inv�s da mensagem no corpo do e-mail.
    //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
    $mail->Send();
    header("Location: sucesso.html");
 
    //caso apresente algum erro � apresentado abaixo com essa exce��o.
    }

    catch (phpmailerException $e) {
        
        echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
?>