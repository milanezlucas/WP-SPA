<?php
$param1 = get_query_var('param1');
$param2 = get_query_var('param2');

if ( $param1 == 'menu' ) {
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $param2 ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $param2 ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        $i = 0;
        foreach ( ( array ) $menu_items as $key => $menu_item ) {
            $id = $menu_item->ID;

            @$mn->$i->url   = basename( esc_url( $menu_item->url ) );
            @$mn->$i->title	= $menu_item->title;

            $i++;
        }

        wp_send_json_success( $mn );
    }
} elseif ( $param1 == 'routes' ) {
    $routes = array();

	$query = new WP_Query( array(
		'post_type'      => array( 'post', 'page' ),
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$routes[] = array(
				'id'   => get_the_ID(),
				'type' => get_post_type(),
				'slug' => basename( get_permalink() ),
			);
		}
	}
	wp_reset_postdata();

	wp_send_json_success( $routes );
} else {
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
  </head>
  <body>
    <div id="app">
        <theme-header></theme-header>
        <router-view></router-view>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
<?php
}