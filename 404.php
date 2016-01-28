<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Arenson
 * @since Arenson 1.0
 */


get_header(); ?>

	<div id="primary" class="site-content centering_box">

		<header class="page-header">
			<h1 class="page-title">Page not found.</h1>
			<hr/>
		</header>


		<div id="content" class="error404" role="main">

			<div class="entry-content">
				<h3>Don't give up! Try a search below or contact Arenson so we can help you find exactly what you need.</h3>

				<?php get_search_form(); ?>
		
				<h3><br/>Get in touch.</h3>

				<h5 class="contact_info404">(212) 633 2400<br />info@aof.com</h5>
				<h5 class="contact_info404">1115 Broadway<br />New York, NY 10010</h5>
				<h5 class="contact_info404"><a href="<?php echo site_url('/contact'); ?>">See our full contact information »</a></h5>

				<? //phpinfo(); ?>
			</div><!-- .entry-content -->

		</div><!-- #content -->
	</div><!-- #primary .site-content -->

<?php get_footer(); ?>