<script src="<?= base_url('assets/js/jquery.2.0.3.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.reveal.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/iscroll.js') ?>"></script>
<?php
	if(isset($scriptPath)) {
		foreach ($scriptPath as $script) {
			echo '<script src="'.base_url($script).'"></script>';
		}
	}
?>
</body>
</html>