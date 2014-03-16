<script src="/assets/js/jquery.2.0.3.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.reveal.js"></script>
<script type="text/javascript" src="/assets/js/iscroll.js"></script>
<?php
	if(isset($scriptPath)) {
		foreach ($scriptPath as $script) {
			echo '<script src="'.$script.'"></script>';
		}
	}
?>
</body>
</html>