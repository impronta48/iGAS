<!DOCTYPE html>
<html lang="it">

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> |
		<?php echo "iGas - " . Configure::read('iGas.NomeAzienda') ?>
	</title>
	
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-startup-image" href="/<?= APP_DIR ?>/img/startup.png">
	<link rel="apple-touch-icon" href="/<?= APP_DIR ?>/img/favicon-igas.png"/>
	<link rel="apple-touch-icon-precomposed" sizes="128x128" href="/<?= APP_DIR ?>/img/favicon-igas-128.png">

	<meta name="mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" sizes="196x196" href="/<?= APP_DIR ?>/img/favicon-igas.png">
	<link rel="shortcut icon" sizes="128x128" href="/<?= APP_DIR ?>/img/favicon-igas-128.png">
	<link rel="manifest" href="/<?= APP_DIR ?>/manifest.webmanifest">

	<?php echo $this->Html->css('font-awesome'); ?>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="MobileOptimized" content="width" />
	<meta name="HandheldFriendly" content="true" />
	<meta http-equiv=“Content-Security-Policy” content=“default-src ‘self’ gap://ready file://* *; style-src ‘self’ ‘unsafe-inline’; script-src ‘self’ ‘unsafe-inline’ ‘unsafe-eval’” />

	<?= $this->Html->css('fontawesome5.11.2/css/all'); ?>
	<?= $this->Html->css('vue/bootstrap.min.4.4.1'); ?>
	<?= $this->Html->css('vue/bootstrap-vue.min.2.6.1'); ?>
	<link rel="stylesheet" href="//unpkg.com/leaflet/dist/leaflet.css" />
	<?= $this->Html->css('style'); ?>
	<?= $this->fetch('css'); ?>

	<?= $this->Html->script('jQuery/3.3.1/jquery-3.3.1.min'); ?>
	<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin></script>
	<?= $this->Html->script('vue/dep/vue'); ?>
	<?= $this->Html->script('vue/dep/bootstrap-vue.min.2.6.1'); ?>
	<?= $this->Html->script('vue/dep/vue-resource@1.5.1'); ?>
	<script>
		Vue.http.options.withCredentials = true;
	</script>
	<?= $this->Html->script('vue/dep/axios.min'); ?>
	<script>
		Vue.use('axios');
	</script>
	<script src="//unpkg.com/leaflet/dist/leaflet.js" crossorigin></script>
	<script src="//unpkg.com/vue2-leaflet" crossorigin></script>
	<script>
		Vue.component('l-map', window.Vue2Leaflet.LMap);
	</script>

	<?= $this->Html->script('vue/dep/moment.min'); ?>
	<?= $this->Html->script('vue/dep/moment-with-locales'); ?>
	<?= $this->Html->script('vue/dep/vue-moment'); ?>
	<script>
		Vue.use('vue-moment');
	</script>
	<?= $this->Html->script('vue/common/util'); ?>
	<?= $this->Html->script('vue/common/map'); ?>

</head>

<style>
	#main {
		min-height: 95vh;
		height: 100%
	}
</style>

<body>
	<nav class="navbar bg-white navbar-fixed-top">
		<div class="container">
			<div class="navbar-header mt-0">
				<?= $this->Html->image('logo-igas.png', ['alt'=>'iGAS Gestione Aziendale Semplice', 'style' => 'height:70px']); ?>
			</div>
			<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="<?= $this->Html->url(['controller'=> 'users', 'action'=>'logout']) ?>" class="btn btn-primary btn-sm ">
							<i class="fa fa-user-circle"></i> Logout
						</a>
					</li>
			</ul>
		</div>
	</nav>
	<div class="container my-2">
		<div role="main" id="main" class="p-3">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<div class="row">
		<div class="footer m-0 mt-1" style="font-size:0.8rem;position:relative">
			<?php echo $this->element('footer', [], ["cache" => "long_view"]); ?>
		</div>
	</div>

	<script>
		SERVER_BASE_URL = '<?= Router::url('/', true); ?>';
	</script>
	<?php echo $this->fetch('script'); ?>

</body>

</html>