<?php $this->load->view('header', array('cssPath' => '/assets/css/generator.css')); ?>

<div id="wrapper" class="margin-auto">
	<div id="content" class="fade-background margin-auto">
		<header>
			<h1>Zápis do knihy mien</h1>
		</header>
        <form action="<?= site_url('api/generator')?>" method="POST" id="generator">
			<label for="race">Rasa:</label>
			<select name="race" id="race">
				<option value="svetli-elfovia">Svetlí elfovia</option>
				<option value="temni-elfovia">Temní elfovia</option>
				<option value="severania">Severania</option>
				<option value="juzania">Južania</option>
				<option value="cigani">Cigáni</option>
			</select>
			<label for="name">Pridaj meno do knihy mien:</label>
			<input type="text" name="name" id="name" />
			<input type="submit" value="Pridať do knihy" />
		</form>
		<div id="msg"></div>
	</div>
</div>

<?php $this->load->view('footer', array('scriptPath' => array('/assets/js/generator.js'))); ?>