<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title><?php echo $page->get('title'); ?></title>
		
		<link rel="shortcut icon" href="http://images.hamsterpaj.net/favicon.png" type="image/x-icon" />
		
		<meta name="title" content="<?php echo $page->get('title'); ?>" />
		<meta name="description" content="<?php echo $page->get('description'); ?>" />
		<meta name="keywords" content="<?php echo strtolower($page->get('keywords')); ?>" />
		
		<link rel="image_src" href="http://images.hamsterpaj.net/fp_recent_update_thumb_universal.png" />
		
		<style type="text/css">
			<?php if (ENVIRONMENT == 'development' || !file_exists(PATH_WEBROOT . 'stylesheet_cache.css')): ?>
			@import url('/style.css');
			<?php else: ?>
			@import url('/stylesheet_cache.<?php echo filemtime(PATH_WEBROOT . 'stylesheet_cache.css'); ?>.css');
			<?php endif; ?>
			<?php if ( IS_HP3_REQUEST ): ?>
			@import url('/old_style.css:<?php echo implode(',', $page->extra_css); ?>');
			<?php endif; ?>
		</style>
		
		<!-- HP JavaScript -->
		<script type="text/javascript">
		    window.hp = {};
		    window.hp.login_checklogin = function() {
			return <?php echo (int)$page->user->exists(); ?>;
		    };
		</script>
		<?php if (ENVIRONMENT == 'development' || !file_exists(PATH_WEBROOT . 'javascript_cache.js')): ?>
			<script src="/scripts.js" type="text/javascript"></script>
		<?php else: ?>
			<script src="/javascript_cache.<?php echo filemtime(PATH_WEBROOT . 'javascript_cache.js'); ?>.js" type="text/javascript"></script>
		<?php endif; ?>
		<?php foreach ( Tools::pick($page->extra_js, array()) as $script ): ?>
		<script type="text/javascript" src="http://iphone2.hamsterpaj.net/javascripts/<?php echo $script; ?>"></script>
		<?php endforeach; ?>
		
		<!-- Ad JavaScript -->
		<script type="text/javascript" src="http://nyheter24.se/template/1-0-1/javascript/ads.js?20090605"></script>
		<script type="text/javascript">Ads.init('http://ads.nyheter24.se/', false);</script>
	</head>
	
	<body>
		<?php
		if(isset($page->user->user_message))
	  {
	    echo jscript_alert($page->user->user_message);
	    unset($page->user->user_message);
	  }
		?>

		<div id="wrapper">
			<script type='text/javascript'><!--//<![CDATA[
				Ads.insert(250, 'banner980x120 noprint');
			//]]>--></script>
			
			<div id="hp">
				<div id="head">
				<img id="steve" src="http://images.hamsterpaj.net/steve/steve.gif" alt="" />
				<h2><a href="/">Hamsterpaj.net</a></h2>
					<?php if( $page->user->exists() ) : ?>
						<?php echo template('user', 'noticebar.php', array('user' => $page->user, 'page' => $page)); ?>
						<?php echo template('user', 'statusbar.php', array('user' => $page->user)); ?>
					<?php else : ?>
						<?php echo template('user', 'loginbar.php'); ?>
					<?php endif; ?>
				</div>
				<?php echo $page->menu->render($page); ?>
				<div id="xxl">
					<?php echo isset($page->xxl) ? $page->xxl : ''; ?>
				</div>
				
				<div id="content_container">
				    <div id="content">
					    <?php $update = $page->user->get_recent_update(); ?>
					    <?php if ( $update ): ?>
					    <div id="updates">
						<p><a href="<?php echo $update['link']; ?>"><?php echo $update['text']; ?></a></p>
					    </div>
					    <?php endif; ?>
					    <?php foreach ( $page->user->fetch_notifications() as $note ): ?>
						<?php echo call_user_func_array('template', $note); ?>
					    <?php endforeach; ?>
					    
					    <?php echo $page->content; ?>
				    </div>
				    <div id="modules">
					    <?php foreach($page->side_modules AS $module) : ?>
						    <div class="module <?php echo $module->is_closed ? 'minimized' : ''; ?> <?php echo $module->is_sortable ? 'sortable_module' : ''; ?>" <?php echo isset($module->id) ? ' id="side_module_' . $module->id . '"' : '' ?>>
							    <?php echo $module->execute($page); ?>
						    </div>
					    <?php endforeach; ?>
				    </div>
				</div>
			</div>
			<div id="column_ads">
				<script type='text/javascript'><!--//<![CDATA[
        Ads.insert(316, '');
      //]]>--></script>

				<script type='text/javascript'><!--//<![CDATA[
					Ads.insert(251, '');
					Ads.insert(252, '');
				//]]>--></script>
			
				<script type="text/javascript"><!--
					google_ad_client = "pub-3110640362329253";
					/* hamsterpaj 160x600, skapad 2009-06-08 */
					google_ad_slot = "0695149486";
					google_ad_width = 160;
					google_ad_height = 600;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>

		</div>
		
		<!-- Clickheat -->
		<?php if(isset($page->clickheat)): ?>
		<script type="text/javascript" src="http://www.hamsterpaj.net/clickheat/js/clickheat.js"></script>
		<noscript><p><a href="http://www.labsmedia.com/index.html">Traffic monetization</a></p></noscript>
		<script type="text/javascript"><!--
			clickHeatSite = 'hamsterpaj';
			clickHeatGroup = '<?php echo $page->clickheat; ?>';
			clickHeatQuota = 3;
			clickHeatServer = 'http://www.hamsterpaj.net/clickheat/click.php';
			initClickHeat(); //-->
		</script>
		<?php endif; ?>
		<!-- End Clickheat Tag -->
		
		<!-- Google Analytics -->
		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-10835550-1");
		pageTracker._trackPageview();
		} catch(err) {}</script>

	 	<!-- Kiaindex -->
		<img src="http://sifomedia.nyheter24.se/RealMedia/ads/adstream_nx.ads/nyheter24/123645@TopRight?XE&Sajt=hamsterpaj&Grupp1=nyheter24natverket&XE" border="0" alt="" />		
	</body>
</html>
