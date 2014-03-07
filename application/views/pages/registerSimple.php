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
			<form action="" method="post" name="user" id="user">

			<h1 class="step-1">Vytvorenie účtu</h1>
			<div class="intro step-1">
				<p>Pre vstup do Gallenmoru budeš používať jeden jediný účet, na ktorom môžeš mať viacero postáv. Prosíme Ťa, aby si poctivo vyplnil všetky polia. Na Tvoj email <u>nikdy</u> nepošleme spam a nikomu ho neposkytneme ďalej. Slúži výhradne na posielanie zabudnutého hesla alebo oznamovanie veľkých udalostí (nové funkcie na stránke, masívne RPG udalosti, etc.). Dátum narodenia nikde nezobrazujeme, slúži na interné účely. Tieto údaje sú o Tebe ako reálnej osobe. Ku vytvoreniu postavy sa dostaneš v neskoršom kroku.</p>
			</div>
			<div class="fade-borders fade-background step-1">
				<input type="text" name="username" class="step-1" placeholder="používateľské meno" required="required"/><div id="msg-username" class="error"></div>
				<input type="text" name="email" class="step-1" placeholder="email" required="required"/><div id="msg-email" class="error"></div>
				<input type="password" name="password" class="step-1" placeholder="heslo" required="required"/><div id="msg-password" class="error"></div>
				<input type="password" name="password-check" class="step-1" placeholder="kontrola hesla" required="required"/><div id="msg-password-check" class="error"></div>
				<input type="text" name="date" class="step-1" placeholder="dátum narodenia (yyyy-mm-dd)" required="required"/><div id="msg-date" class="error"></div>
			</div>
			<a href="#" data-step="2" class="step-1 fade-borders border-button fade-background">Ďalší krok</a>

			<h1 class="step-2">Výber rasy</h1>
			<h2 class="step-2" id="race-headline">Svetlí Elfovia</h2>
			<div class="intro step-2">Ak sa chceš dozvedieť viac o tejto rase, klikni na Erb.</div>
			<div class="fade-borders fade-background step-2">
				<input type="hidden" name="race" id="race" class="step-2" value="svetli-elfovia"/>
				<div class="race-pick">
					<span class="scroller-arrow arrow-left" data-dir="left">&larr;</span>
					<div class="erbs" id="scroll-wrapper">
						<div class="scroller">
							<div class="erb erb-svetli-elfovia"></div>
							<div class="erb erb-juzania"></div>
							<div class="erb erb-severania"></div>
							<div class="erb erb-cigani"></div>
							<div class="erb erb-temni-elfovia"></div>
						</div><!-- scroll-wrapper -->
					</div><!-- erbs -->
					<span class="scroller-arrow arrow-right" data-dir="right">&rarr;</span>
					<div id="msg-race" class="error"></div>
				</div> <!-- race-pick -->
			</div><!-- step-2 -->
			<a href="#" data-step="3" class="step-2 fade-borders border-button fade-background">Ďalší krok</a>
			<a href="#" data-step="1" data-back="true" class="step-2 back">Späť</a>

			<h1 class="step-3">Výber rasy</h1>
			<a href="#" data-step="2" data-back="true" class="step-3 back">Späť</a>
		</div>
	</div>
</div>
<div id="modal" class="reveal-modal xlarge">
	<h1>Reveal Modal Goodness</h1>
	<p>This is a default modal in all its glory, but any of the styles here can easily be changed in the CSS.</p>
	<a class="close-reveal-modal">&#215;</a>
</div>
<?php $this->load->view('footer', array('scriptPath' => '/assets/js/register.js')); ?>