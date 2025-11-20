<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- :) -->

<?php get_header(); ?>

<div id="myWrapper">
    <?php my_include_main(); ?>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

<!-- ): -->

</body>
</html>