
<?php
$subjectPrefix = '[ORÇAMENTO]';
$emailTo = '<contato@scripting.com.br>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = stripslashes(trim($_POST['form-name']));
$email = stripslashes(trim($_POST['form-email']));
$subject = stripslashes(trim($_POST['form-subject']));
$message = stripslashes(trim($_POST['form-message']));
$pattern = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $subject)) {
die("Header injection detected");
}
$emailIsValid = preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $email);
if($name && $email && $emailIsValid && $subject && $message){
$subject = "$subjectPrefix $subject";
$body = "Nome: $name <br /> Email: $email <br /> Mensagem: $message";
$headers = 'MIME-Version: 1.1' . PHP_EOL;
$headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
$headers .= "From: $name <$email>" . PHP_EOL;
$headers .= "Return-Path: $emailTo" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
mail($emailTo, $subject, $body, $headers);
$emailSent = true;
} else {
$hasError = true;
}
}
?>
<div class="jumbotron">
	<h3>Faça um orçamento!</h3>
</div>
<?php if(!empty($emailSent)): ?>
<div class="col-md-6 col-md-offset-3">
<div class="alert alert-success text-center">Sua mensagem foi enviada com sucesso.</div>
</div>
<?php else: ?>
<?php if(!empty($hasError)): ?>
<div class="col-md-5 col-md-offset-4">
<div class="alert alert-danger text-center">Houve um erro no envio, tente novamente mais tarde.</div>
</div>
<?php endif; ?>
<div class="col-md-6 col-md-offset-3">
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="contact-form" class="form-horizontal" role="form" method="post">
<div class="form-group">
<label for="name" class="col-lg-2 control-label">Nome</label>
<div class="col-lg-10">
<input type="text" class="form-control required" id="form-name" name="form-name" placeholder="Nome" />
</div>
</div>
<div class="form-group">
<label for="email" class="col-lg-2 control-label">Email</label>
<div class="col-lg-10">
<input type="email" class="form-control required" id="form-email" name="form-email" placeholder="Email" />
</div>
</div>
<div class="form-group">
<label for="assunto" class="col-lg-2 control-label">Assunto</label>
<div class="col-lg-10">
<input type="text" class="form-control required" id="form-subject" name="form-subject" placeholder="Assunto" value="Orçamento"/>
</div>
</div>
<div class="form-group">
<label for="mensagem" class="col-lg-2 control-label">Mensagem</label>
<div class="col-lg-10">
<textarea class="form-control required" rows="3" id="form-message" name="form-message" placeholder="Mensagem" /></textarea>
</div>
</div>
<div class="form-group">
<div class="col-lg-offset-2 col-lg-10">
<button type="submit" class="btn btn-default">Enviar</button>
</div>
</div>
</form>
</div>
<?php endif; ?>
