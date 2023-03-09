<?php
/**
 * muf-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package muf-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function muf_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on muf-theme, use a find and replace
		* to change 'muf-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'muf-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'muf-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'muf_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'muf_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function muf_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'muf_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'muf_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function muf_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'muf-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'muf-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'muf_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function muf_theme_scripts() {
    wp_enqueue_style( 'muf-theme-fancybox', get_template_directory_uri() . '/css/fancybox.css', array(), _S_VERSION);
    wp_enqueue_style( 'muf-theme-select2', get_template_directory_uri() . '/css/select2.min.css', array(), _S_VERSION);

	wp_enqueue_style( 'muf-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'muf-theme-style', 'rtl', 'replace' );
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'muf-theme-fancybox', get_template_directory_uri() . '/js/fancybox.umd.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'muf-theme-select2', get_template_directory_uri() . '/js/select2.min.js', array(), _S_VERSION, true );
    wp_register_script( 'muf-theme-main', get_template_directory_uri() . '/js/main.js', array('jquery'), _S_VERSION, true );

    wp_localize_script( 'muf-theme-main', 'muf', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
    ) );

    wp_enqueue_script( 'muf-theme-main' );
}
add_action( 'wp_enqueue_scripts', 'muf_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function get_country_data(){
    $countries = array(
        'af' => 'Afghanistan',
        'ax' => 'Åland Islands',
        'al' => 'Albania',
        'dz' => 'Algeria',
        'as' => 'American Samoa',
        'ad' => 'Andorra',
        'ao' => 'Angola',
        'ai' => 'Anguilla',
        'ag' => 'Antigua and Barbuda',
        'ar' => 'Argentina',
        'am' => 'Armenia',
        'aw' => 'Aruba',
        'au' => 'Australia',
        'at' => 'Austria',
        'az' => 'Azerbaijan',
        'bs' => 'Bahamas',
        'bh' => 'Bahrain',
        'bd' => 'Bangladesh',
        'bb' => 'Barbados',
        'by' => 'Belarus',
        'be' => 'Belgium',
        'bz' => 'Belize',
        'bj' => 'Benin',
        'bm' => 'Bermuda',
        'bt' => 'Bhutan',
        'bo' => 'Bolivia',
        'ba' => 'Bosnia and Herzegovina',
        'bw' => 'Botswana',
        'br' => 'Brazil',
        'io' => 'British Indian Ocean Territory',
        'vg' => 'British Virgin Islands',
        'bn' => 'Brunei',
        'bg' => 'Bulgaria',
        'bf' => 'Burkina Faso',
        'bi' => 'Burundi',
        'kh' => 'Cambodia',
        'cm' => 'Cameroon',
        'ca' => 'Canada',
        'cv' => 'Cape Verde',
        'bq' => 'Caribbean Netherlands',
        'ky' => 'Cayman Islands',
        'cf' => 'Central African Republic',
        'td' => 'Chad',
        'cl' => 'Chile',
        'cn' => 'China',
        'cx' => 'Christmas Island',
        'cc' => 'Cocos (Keeling) Islands',
        'co' => 'Colombia',
        'km' => 'Comoros',
        'cd' => 'Congo (DRC)',
        'cg' => 'Congo (Republic)',
        'ck' => 'Cook Islands',
        'cr' => 'Costa Rica',
        'ci' => 'Côte d’Ivoire',
        'hr' => 'Croatia',
        'cu' => 'Cuba',
        'cw' => 'Curaçao',
        'cy' => 'Cyprus',
        'cz' => 'Czech Republic',
        'dk' => 'Denmark',
        'dj' => 'Djibouti',
        'dm' => 'Dominica',
        'do' => 'Dominican Republic',
        'ec' => 'Ecuador',
        'eg' => 'Egypt',
        'sv' => 'El Salvador',
        'gq' => 'Equatorial Guinea',
        'er' => 'Eritrea',
        'ee' => 'Estonia',
        'et' => 'Ethiopia',
        'fk' => 'Falkland Islands',
        'fo' => 'Faroe Islands',
        'fj' => 'Fiji',
        'fi' => 'Finland',
        'fr' => 'France',
        'gf' => 'French Guiana',
        'pf' => 'French Polynesia',
        'ga' => 'Gabon',
        'gm' => 'Gambia',
        'ge' => 'Georgia',
        'de' => 'Germany',
        'gh' => 'Ghana',
        'gi' => 'Gibraltar',
        'gr' => 'Greece',
        'gl' => 'Greenland',
        'gd' => 'Grenada',
        'gp' => 'Guadeloupe',
        'gu' => 'Guam',
        'gt' => 'Guatemala',
        'gg' => 'Guernsey',
        'gn' => 'Guinea',
        'gw' => 'Guinea-Bissau',
        'gy' => 'Guyana',
        'ht' => 'Haiti',
        'hn' => 'Honduras',
        'hk' => 'Hong Kong',
        'hu' => 'Hungary',
        'is' => 'Iceland',
        'in' => 'India',
        'id' => 'Indonesia',
        'ir' => 'Iran',
        'iq' => 'Iraq',
        'ie' => 'Ireland',
        'im' => 'Isle of Man',
        'il' => 'Israel',
        'it' => 'Italy',
        'jm' => 'Jamaica',
        'jp' => 'Japan',
        'je' => 'Jersey',
        'jo' => 'Jordan',
        'kz' => 'Kazakhstan',
        'ke' => 'Kenya',
        'ki' => 'Kiribati',
        'xk' => 'Kosovo',
        'kw' => 'Kuwait',
        'kg' => 'Kyrgyzstan',
        'la' => 'Laos',
        'lv' => 'Latvia',
        'lb' => 'Lebanon',
        'ls' => 'Lesotho',
        'lr' => 'Liberia',
        'ly' => 'Libya',
        'li' => 'Liechtenstein',
        'lt' => 'Lithuania',
        'lu' => 'Luxembourg',
        'mo' => 'Macau',
        'mk' => 'Macedonia',
        'mg' => 'Madagascar',
        'mw' => 'Malawi',
        'my' => 'Malaysia',
        'mv' => 'Maldives',
        'ml' => 'Mali',
        'mt' => 'Malta',
        'mh' => 'Marshall Islands',
        'mq' => 'Martinique',
        'mr' => 'Mauritania',
        'mu' => 'Mauritius',
        'yt' => 'Mayotte',
        'mx' => 'Mexico',
        'fm' => 'Micronesia',
        'md' => 'Moldova',
        'mc' => 'Monaco',
        'mn' => 'Mongolia',
        'me' => 'Montenegro',
        'ms' => 'Montserrat',
        'ma' => 'Morocco',
        'mz' => 'Mozambique',
        'mm' => 'Myanmar',
        'na' => 'Namibia',
        'nr' => 'Nauru',
        'np' => 'Nepal',
        'nl' => 'Netherlands',
        'nc' => 'New Caledonia',
        'nz' => 'New Zealand',
        'ni' => 'Nicaragua',
        'ne' => 'Niger',
        'ng' => 'Nigeria',
        'nu' => 'Niue',
        'nf' => 'Norfolk Island',
        'kp' => 'North Korea',
        'mp' => 'Northern Mariana Islands',
        'no' => 'Norway',
        'om' => 'Oman',
        'pk' => 'Pakistan',
        'pw' => 'Palau',
        'ps' => 'Palestine',
        'pa' => 'Panama',
        'pg' => 'Papua New Guinea',
        'py' => 'Paraguay',
        'pe' => 'Peru',
        'ph' => 'Philippines',
        'pn' => 'Pitcairn Islands',
        'pl' => 'Poland',
        'pt' => 'Portugal',
        'pr' => 'Puerto Rico',
        'qa' => 'Qatar',
        're' => 'Réunion',
        'ro' => 'Romania',
        'ru' => 'Russia',
        'rw' => 'Rwanda',
        'bl' => 'Saint Barthélemy',
        'sh' => 'Saint Helena',
        'kn' => 'Saint Kitts and Nevis',
        'lc' => 'Saint Lucia',
        'mf' => 'Saint Martin',
        'pm' => 'Saint Pierre and Miquelon',
        'vc' => 'Saint Vincent and the Grenadines',
        'ws' => 'Samoa',
        'sm' => 'San Marino',
        'st' => 'São Tomé and Príncipe',
        'sa' => 'Saudi Arabia',
        'xs' => 'Scotland',
        'sn' => 'Senegal',
        'rs' => 'Serbia',
        'sc' => 'Seychelles',
        'sl' => 'Sierra Leone',
        'sg' => 'Singapore',
        'sx' => 'Sint Maarten',
        'sk' => 'Slovakia',
        'si' => 'Slovenia',
        'sb' => 'Solomon Islands',
        'so' => 'Somalia',
        'za' => 'South Africa',
        'gs' => 'South Georgia & South Sandwich Islands',
        'kr' => 'South Korea',
        'ss' => 'South Sudan',
        'es' => 'Spain',
        'lk' => 'Sri Lanka',
        'sd' => 'Sudan',
        'sr' => 'Suriname',
        'sj' => 'Svalbard and Jan Mayen',
        'sz' => 'Swaziland',
        'se' => 'Sweden',
        'ch' => 'Switzerland',
        'sy' => 'Syria',
        'tw' => 'Taiwan',
        'tj' => 'Tajikistan',
        'tz' => 'Tanzania',
        'th' => 'Thailand',
        'tl' => 'Timor-Leste',
        'tg' => 'Togo',
        'tk' => 'Tokelau',
        'to' => 'Tonga',
        'tt' => 'Trinidad and Tobago',
        'tn' => 'Tunisia',
        'tr' => 'Turkey',
        'tm' => 'Turkmenistan',
        'tc' => 'Turks and Caicos Islands',
        'tv' => 'Tuvalu',
        'ug' => 'Uganda',
        'ua' => 'Ukraine',
        'ae' => 'United Arab Emirates',
        'gb' => 'United Kingdom',
        'us' => 'United States',
        'um' => 'U.S. Minor Outlying Islands',
        'vi' => 'U.S. Virgin Islands',
        'uy' => 'Uruguay',
        'uz' => 'Uzbekistan',
        'vu' => 'Vanuatu',
        'va' => 'Vatican City',
        've' => 'Venezuela',
        'vn' => 'Vietnam',
        'xw' => 'Wales',
        'wf' => 'Wallis and Futuna',
        'eh' => 'Western Sahara',
        'ye' => 'Yemen',
        'zm' => 'Zambia',
        'zw' => 'Zimbabwe',
    );

    return $countries;
}
function get_status_data(){
    $statuses = array(
        1 => 'Nomination',
        2 => 'Top 5 Priorities',
        3 => 'Ranking',
        4 => 'Potential Solutions',
        5 => 'Potential Solutions - Review',
        6 => 'Project',
    );

    return $statuses;
}
function acf_load_select_country( $field ) {
    // Reset choices
    $field['choices'] = array();

    // Get field from options page
    $countries = get_country_data();

    // Populate choices
    foreach( $countries as $key => $value ) {
        $field['choices'][ $key ] = $value;
    }

    // Return choices
    return $field;

}
// Populate select field using filter
add_filter('acf/load_field/key=field_63f7760829528', 'acf_load_select_country');
add_filter('acf/load_field/key=field_63f726d277cbb', 'acf_load_select_country');
add_filter('acf/load_field/key=field_6407324a120c2', 'acf_load_select_country');

function acf_load_select_status( $field ) {
    // Reset choices
    $field['choices'] = array();

    // Get field from options page
    $statuses = get_status_data();

    // Populate choices
    foreach( $statuses as $key => $value ) {
        $field['choices'][ $key ] = $value;
    }

    // Return choices
    return $field;

}
// Populate select field using filter
add_filter('acf/load_field/key=field_63f7264977cba', 'acf_load_select_status');

add_action('wp_ajax_add_request', 'add_request');
add_action('wp_ajax_nopriv_add_request', 'add_request');
function add_request(){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $ajax_crop_hidden = $_POST['ajax-crop-hidden'];
    $ajax_target_hidden = $_POST['ajax-target-hidden'];
    $solution = $_POST['solution'];
    $field = $_POST['field'];
    $zone = $_POST['zone'];
    $country = $_POST['country'];
    $workshop_id = $_POST['workshop_id'];


    $args = array(
        'post_title' => $first_name.' '.$last_name,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'request'
    );

    $post_id = wp_insert_post( $args );
    update_field('crop_en_commonscientific_name', $ajax_crop_hidden, $post_id);
    update_field('target_en_commonscientific_name', $ajax_target_hidden, $post_id);
    update_field('field', $field, $post_id);
    update_field('climate_zone', $zone, $post_id);
    update_field('country', $country, $post_id);
    update_field('first_name', $first_name, $post_id);
    update_field('last_name', $last_name, $post_id);
    update_field('email', $email, $post_id);
    update_field('solution', $solution, $post_id);
    update_field('workshop_id', $workshop_id, $post_id);
    die();
}

add_action('wp_ajax_add_workshop', 'add_workshop');
add_action('wp_ajax_nopriv_add_workshop', 'add_workshop');
function add_workshop(){
    $title = $_POST['title'];
    $emails = $_POST['emails'];
    $countries = $_POST['countries'];
    $status = $_POST['status'];

    $args = array(
        'post_title' => $title,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'workshop'
    );

    $post_id = wp_insert_post( $args );
    update_field('status', $status, $post_id);
    update_field('country_list', $countries, $post_id);
    update_field('email_list', $emails, $post_id);
    die();
}

add_action('wp_ajax_update_workshop', 'update_workshop');
add_action('wp_ajax_nopriv_update_workshop', 'update_workshop');
function update_workshop(){
    $title = $_POST['title'];
    $emails = $_POST['emails'];
    $countries = $_POST['countries'];
    $status = $_POST['status'];
    $post_id = $_POST['workshop_id'];

    $my_post = [
        'ID' => $post_id,
        'post_title' => $title,
    ];

    wp_update_post( wp_slash( $my_post ) );

    update_field('status', $status, $post_id);
    update_field('country_list', $countries, $post_id);
    update_field('email_list', $emails, $post_id);
    die();
}

add_action('rest_api_init', 'add_acf_fields_to_custom_post_type');

function add_acf_fields_to_custom_post_type() {
    register_rest_field('workshop', 'acf_fields', array(
        'get_callback' => 'get_acf_fields',
        'schema' => null,
    ));
}

function get_acf_fields($object, $field_name, $request) {
    $post_id = $object['id'];
    $acf_fields = get_fields($post_id);
    return $acf_fields;
}

function ajax_crop(){
    $search = $_POST['search'];
    $args = array(
        'post_type' => 'crop_eppo_codes',
        'posts_per_page' => 6,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'eppo_code',
                'value' => $search,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'name',
                'value' => $search,
                'compare' => 'LIKE'
            )
        )
    );
    query_posts($args);
    while (have_posts()): the_post();
        $meta_1 = get_field('eppo_code');
        $meta_2 = get_field('name');
        $eppo = stristr($meta_1, $search);
        $name = stristr($meta_2, $search);
        $value = $meta_2;
        if(strlen($eppo) > $name){
            $value = $meta_1;
        }
        ?>
        <div class="search-value-crop" data-value="<?php echo $value;?>" data-id="<?php echo get_the_ID();?>">
            <?php echo $value;?>
        </div>
    <?php endwhile;
    wp_reset_postdata();
    die();
}

add_action('wp_ajax_ajax_crop', 'ajax_crop');
add_action('wp_ajax_nopriv_ajax_crop', 'ajax_crop');

function ajax_target(){
    $search = $_POST['search'];
    $args = array(
        'post_type' => 'target_eppo_codes',
        'posts_per_page' => 6,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'eppo_code',
                'value' => $search,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'name',
                'value' => $search,
                'compare' => 'LIKE'
            )
        )
    );
    query_posts($args);
    while (have_posts()): the_post();
        $meta_1 = get_field('eppo_code');
        $meta_2 = get_field('name');
        $eppo = stristr($meta_1, $search);
        $name = stristr($meta_2, $search);
        $value = $meta_2;
        if(strlen($eppo) > $name){
            $value = $meta_1;
        }
        ?>
        <div class="search-value-target" data-value="<?php echo $value;?>" data-id="<?php echo get_the_ID();?>">
            <?php echo $value;?>
        </div>
    <?php endwhile;
    wp_reset_postdata();
    die();
}

add_action('wp_ajax_ajax_target', 'ajax_target');
add_action('wp_ajax_nopriv_ajax_target', 'ajax_target');

function ajax_priorities(){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $workshop_id = $_POST['workshop_id'];

    $priority = $_POST['priority'];
    $counter = 1;
    $score = 0;
    $args = array(
        'post_title' => $first_name.' '.$last_name,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'potential_solution'
    );
    $post_id_new = wp_insert_post( $args );

    foreach ($priority as $value){
        switch ($counter){
            case 2:
                $score = 4;
                break;
            case 3:
                $score = 3;
                break;
            case 4:
                $score = 2;
                break;
            case 5:
                $score = 1;
                break;
            default:
                $score = 5;
        }
        $counter++;
        update_row('priorities', $counter, array('requests_id' => $value, 'priority' => $score), $post_id_new);
    }

    update_field('country', $country, $post_id_new);
    update_field('first_name', $first_name, $post_id_new);
    update_field('last_name', $last_name, $post_id_new);
    update_field('email', $email, $post_id_new);
    update_field('workshop_id', $workshop_id, $post_id_new);
    die();
}

add_action('wp_ajax_ajax_priorities', 'ajax_priorities');
add_action('wp_ajax_nopriv_ajax_priorities', 'ajax_priorities');