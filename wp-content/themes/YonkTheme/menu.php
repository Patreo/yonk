<?php if (has_nav_menu('primary')): ?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'primary', 
						'container' => false, 
						'items_wrap' => '%3$s', 
						'walker' => new Yonk_Nav_Menu()
					)); 
				?>	
			</ul>
		</div>
	</div>
</nav>

<?php endif; ?>