<?php
session_start();
ob_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(0,$_SESSION['status']);
?>

<?php
if($what=='login')
{
?>
<p id="loginFormConsole"></p>
<div id="loadderr"></div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#loginFormConsole').hide();
			$('#loginForm').click(function(){
				$('#loginFormConsole').slideUp();
				$.post('ajaxlogin.php',{
					username: $('input[name=login_username]').val(),
					password: $('input[name=login_password]').val()
					},
					function(data){
						if(data.success)
						{
							location.href=data.redirect;
						}else{
							$('#loginFormConsole').html(data.message).slideDown();
							if(data.dogrulama)
							{
								$('#facebox_loadder').slideDown();
								$('#loadder').slideDown().load('loadderNotUser.php?what=code').height(142);
							}
						}

					}, 'json');
				return false;
			});
			
			$('.load_forgotpwrd > a').click(function(){
				$('#facebox_loadder').slideDown();
				$('#loadder').slideDown().load('loadderNotUser.php?what=forgotpass').height(142);
				return false;
			});
		});
	</script>
		<form method="post" name="loginForm" class="oneForm">
		<h1><?php echo FORM_LOGIN;?></h1>
			<label><?php echo FORM_USERNAMEOREMAIL;?></label><input name="login_username" type="text"/><br>
			<label><?php echo FORM_PASSWORD;?></label><input name="login_password" type="password"/><br>
			<label>&nbsp;</label><p class="load_forgotpwrd"><a href="javascript: void(0)"><?php echo FORM_FORGOTPASSWORD;?></a></p><br>
			<label>&nbsp;</label><button id="loginForm" class="button"><span><?php echo FORM_DOLOGIN;?></span></button>   
		</form>

<?php
}

if($what=='register')
{
?>

<p id="registerFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#registerFormConsole').hide();
			$("#registerForm").click(function(){
				$('#registerFormConsole').slideUp();
				$.post('ajaxregister.php',{
					fullname: $('[name=register_fullname]').val(),
					username: $('[name=register_username]').val(),
					email:    $('[name=register_email]').val(),
					password: $('[name=register_password]').val(),
					
					adshome: $('[name=register_adshome]').val(),
					adsmobile: $('[name=register_adsmobile]').val()
					},
					function(data){
						if(data.success)
						{
							$('#registerFormConsole').html(data.message).slideDown();
							$('[name=register_fullname]').val('');
							$('[name=register_username]').val('');
							$('[name=register_email]').val('');
							$('[name=register_password]').val('');
							
							$('[name=register_adshome]').val('');
							$('[name=register_adsmobile]').val('');
						}else{
							$('#registerFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
	<form method="post" name="registerForm" class="oneForm">
	<h1><?php echo FORM_REGISTER;?></h1>
		<label><?php echo FORM_FULLNAME;?></label><input type="text" name="register_fullname"><br>
		<label><?php echo FORM_USERNAME;?></label><input type="text" name="register_username"><br>
		<label><?php echo FORM_HOME_TEL;?></label><input name="register_adshome" type="text"><br>
		<label><?php echo FORM_MOBILE_TEL;?></label><input name="register_adsmobile" type="text"><br>
		<label><?php echo FORM_EMAIL;?></label><input type="text" name="register_email"><br>
		<label><?php echo FORM_PASSWORD;?></label><input type="password" name="register_password"></label><br>
		<label>&nbsp;</label><button id="registerForm" class="button"><span><?php echo FORM_SIGNUP;?></span></button> 
	</form>
<?php }

if($what=='forgotpass')
{
?>
<p id="forgotpwrdFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#forgotpwrdFormConsole').hide();
			$("#forgotpwrdForm").click(function(){
				$('#forgotpwrdFormConsole').slideUp();
				$.post('ajaxforgotpwrd.php',{
					usernameoremail: $('input[name=forgotpwrd_usernameoremail]').val()
					},
					function(data){
						if(data.success)
						{
							$('#forgotpwrdFormConsole').html(data.message).slideDown();
							$('[name=forgotpwrd_usernameoremail]').val('');
						}else{
							$('#forgotpwrdFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
	<form method="post" name="forgotpwrdForm" class="oneForm">
	<h1><?php echo FORM_FORGOT_PASS;?></h1>
		<label><?php echo FORM_USERNAMEOREMAIL;?></label><input name="forgotpwrd_usernameoremail" type="text"/><br>
		<label>&nbsp;</label><button id="forgotpwrdForm" class="button"><span><?php echo FORM_REMIND_ME;?></span></button>
	</form>
<?php }


if($what=='code')
{
?>
<p id="codeFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#codeFormConsole').hide();
			$("#codeForm").click(function(){
				$('#codeFormConsole').slideUp();
				$.post('ajaxcode.php',{
					usernameoremail: $('input[name=code_usernameoremail]').val()
					},
					function(data){
						if(data.success)
						{
							$('#codeFormConsole').html(data.message).slideDown();
							$('[name=code_usernameoremail]').val('');
						}else{
							$('#codeFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
	<form method="post" name="codeForm" class="oneForm">
	<h1><?php echo FORM_SEND_EMAIL_VERIFY;?></h1>
		<label><?php echo FORM_USERNAMEOREMAIL;?></label><input name="code_usernameoremail" type="text"/><br>
		<label>&nbsp;</label><button id="codeForm" class="button"><span><?php echo FORM_SEND;?></span></button>
	</form>
<?php }

if($what=='onayla')
{
?>
<p id="okFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#okFormConsole').hide();
			$("#okForm").click(function(){
				$('#okFormConsole').slideUp();
				$.post('ajaxok.php',{
					code: $('input[name=ok_usernameoremail]').val()
					},
					function(data){
						if(data.success)
						{
							$('#okFormConsole').html(data.message).slideDown();
							$('[name=ok_usernameoremail]').val('');
						}else{
							location.href=data.redirect;
						}

					}, 'json');
				return false;
			});
		});
	</script>
	<form method="post" name="okForm" class="oneForm">
	<h1><?php echo FORM_EMAIL_VERIFY;?></h1>
		<label><?php echo FORM_WRITE_YOUR_CODE;?></label><input name="ok_usernameoremail" type="text"/><br>
		<label>&nbsp;</label><button id="okForm" class="button"><span><?php echo FORM_NOW_VERIFY;?></span></button> 
	</form>
<?php
}

ob_end_flush(); ?>
