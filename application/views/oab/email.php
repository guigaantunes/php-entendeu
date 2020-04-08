<?php

ini_set('display_errors', 1);

error_reporting(E_ALL);

$from = "testing @ yourdomain";

$to = "guilherme.evangelista@";

$subject = "Verificando o correio do PHP";

$message = "O correio do PHP funciona bem";

$headers = "De:". $from;

mail($to, $subject, $message, $headers);

echo "A mensagem de e-mail foi enviada.";

?>


<?
            $dest   ="guiga.equeirozan@gmail.com";
            $nome   =  "teste";
            $email  =   "guilherme.evangelista@entendeudireito.com.br";
            $ass    =   "guilherme.evangelista@entendeudireito.com.br";
            $msg    =   "";
            $cop    =   "";
           
$mes = '
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#EEEEEE" align="center">
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="700px" align="center" style="width:700px;font-family: Verdana; font-size: 12px;line-height:160%">
				<tr>
					<td bgcolor="#2B2922" style="padding: 15px; color: #FFFFFF" colspan="5">
						<h2>Conteudo novo </h2>
						Opa tudo bom?<br></br>
						Passando aqui so pra falar que temos conteudo novo em nosso site.
						Dá uma passada lá.
					</td>
				</tr>
				<tr>
					<td height="10px" colspan="5"></td>
				</tr>
				<tr>
					<td bgcolor="#A32500" width="5px" style="5px"></td>
					<td bgcolor="#EFE4BD" style="padding: 15px; color: #333333">
						<h3>Título h3</h3>s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					</td>
					<td bgcolor="#EEEEEE" width="10px" style="width:10px"></td>
					<td bgcolor="#EFE4BD" style="padding: 15px; color: #333333">
						<h3>Título h3</h3>
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					</td>
					<td bgcolor="#A32500" width="5px" style="5px"></td>
				</tr>
				<tr>
					<td height="10px" colspan="5"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
';

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

mail($dest, $ass, $mes, $headers);
        ?>