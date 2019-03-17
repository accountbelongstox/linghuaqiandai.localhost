<footer class="navbar-inverse">
	<div class="navbar-inner">

	<div class="footer-content">
	<?php
		$link = $this->Html->link(
			__d('HH_Cloud', 'HH_Cloud %s', strval(Configure::read('Croogo.version'))),
			'http://www.ddweb.com.cn'
		);
	?>
	Powered by <?php echo $link; ?>
	<?php echo $this->Html->image('http://assets.croogo.org/powered_by.png'); ?>
	</div>

	</div>
</footer>