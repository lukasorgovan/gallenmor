<?php $this->load->view('header', array('cssPath' => '/assets/css/register.css')); ?>

<div id="wrapper" class="margin-auto">
	<header>
		<ul id="topmenu" class="margin-auto">
			<li>Info</li>
			<li>Registrácia</li>
			<li>Prihlásenie</li>
		</ul>
	</header>

	<div class="overlay">
		<?php if (isset($error)) { echo $error; } ?>
		<form action="/login" method="post" name="user" id="user">
			<input type="text" name="login" placeholder="email" required="required"/>
			<input type="password" name="password"placeholder="heslo" required="required"/>
			<input type="submit"/>
		</form>
	</div>
</div>

<?php $this->load->view('footer', array('scriptPath' => array('/assets/js/register.js'))); ?>