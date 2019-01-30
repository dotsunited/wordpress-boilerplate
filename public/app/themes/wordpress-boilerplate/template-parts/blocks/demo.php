<?php
/** @var string|null $className */
$className = isset($className) ? $className : null;
/** @var string|null $align */
$align = isset($align) ? $align : null;
?>
<aside class="<?php echo esc_attr($className); ?> <?php echo esc_attr('align' . $align); ?>">
	<div class="container-lg">
		<?php /* echo wordpress_boilerplate_render('template-parts/components/demo'); */ ?>
	</div>
</aside>
