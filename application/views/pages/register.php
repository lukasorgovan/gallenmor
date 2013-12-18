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
		<div id="content" class="margin-auto">
			<a href="/register/simple" class="fade-borders fade-background border-button">Začiatočník</a>
			<a href="/register/advanced" class="fade-borders fade-background border-button">Pokročilý<a>
		</div>
	</div>
</div>

<?php $this->load->view('footer', array('scriptPath' => '/assets/js/register.js')); ?>