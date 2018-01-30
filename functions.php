<?php
define( 'MI_URL',           get_home_url() );
define( 'MI_URL_WP',        get_site_url() );
define( 'MI_URL_THEME',     get_template_directory_uri() );
define( 'MI_PREFIX',        'mi_' );
define( 'MI_SITE_NAME',     get_bloginfo( 'title' ) );
define( 'MI_SITE_EMAIL',    get_bloginfo( 'admin_email' ) );
define( 'MI_TEMPLATEPATH', 	get_template_directory() );

add_theme_support( 'title-tag' );

function rest_theme_scripts() {
	$base_path = rtrim( parse_url( MI_URL, PHP_URL_PATH ), '/' );

	wp_enqueue_script( 'rest-theme-vue', get_template_directory_uri() . '/dist/build.js', array(), '1.0.0', true );
	wp_localize_script( 'rest-theme-vue', 'wp', array(
		'root'      => esc_url_raw( rest_url() ),
		'base_url'  => MI_URL,
		'base_path' => $base_path ? $base_path . '/' : '/',
		'nonce'     => wp_create_nonce( 'wp_rest' ),
		'site_name' => MI_SITE_NAME,
		'routes'    => rest_theme_routes(),
	) );
}
add_action( 'wp_enqueue_scripts', 'rest_theme_scripts' );

function rest_theme_routes()
{
    $routes = array();

	$query = new WP_Query( array(
		'post_type'      => array( 'page', 'post' ),
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

	return $routes;
}

register_nav_menus( array(
    'menu-header'   => 'Menu do Cabeçalho',
));

/**
 * REST API
 */
add_filter( 'query_vars',           'add_query_vars' );
add_filter( 'rewrite_rules_array',  'add_rewrite_rules' );

function add_query_vars( $vars )
{
    array_push( $vars, 'param1', 'param2' );
    return $vars;
}

function add_rewrite_rules( $rules )
{
    global $wp_rewrite;
    $gns_rules = array(
        'api/([^/]+)/([^/]+)/?' => 'index.php?param1=' . $wp_rewrite->preg_index(1) .'&param2=' . $wp_rewrite->preg_index(2),
    );

    $wp_rewrite->rules = $gns_rules + $wp_rewrite->rules;
    return $wp_rewrite->rules;
}