<?php

/**
 * Plugin Name:       Каталог Дилеров
 * Plugin URI:        #
 * Description:       Плагин для управления дилерами и городами
 * Version:           1.0
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 */

if ( !defined( 'ABSPATH' ) ) {
    die();
}

class Dealer_Catalog 
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'register_dealer_catalog' ) );
        add_action( 'init', array( $this, 'add_custom_taxonomies' ), 0 );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );
        add_shortcode('dealer-dir', array($this, 'shortcode_dealer_dir'));
    }

    public function activate()
    {
        flush_rewrite_rules();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }

    public function register_dealer_catalog()
    {
        $labels = array (
            'name' => 'Дилеры',
            'singular_name' => 'Дилер',
            'add_new' => 'Добавить дилера',
            'add_new_item' => 'Добавить дилера',
            'edit_item' => 'Изменить дилера',
            'new_item' => 'Новый дилер',
            'all_items' => 'Все Дилеры',
            'search_items' => 'Найти',
            'not_found' => 'Диллеров нет',
            'not_found_in_trash' => 'Удаленных диллеров нет',
            'menu_name' => 'Каталог дилеров'
        );

        $args = array (
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'menu_icon' => 'dashicons-admin-users',
            'menu_position' => 20,
            'supports' => array( 'title', 'editor' )
        );

        register_post_type( 'dealer_catalog', $args);
    }

    public function enqueue()
    {
        wp_enqueue_style( 'style', plugins_url( '/assets/css/style.css', __FILE__ ) );
        wp_enqueue_script( 'script', plugins_url( '/assets/js/script.js', __FILE__ ) );
    }

    public function add_custom_taxonomies()
    {
        register_taxonomy('city', 'dealer_catalog', array(
            'labels' => array(
                'name' => 'Города',
                'singular_name' => 'Город',
                'menu_name' =>'Города',
                'search_items' => 'Искать города',
                'all_items' => 'Все города',
                'edit_item' => 'Изменить город',
                'view_item' => 'Посмотреть город',
                'update_item' => 'Обновить город',
                'add_new_item' => 'Добавить новый город'
            )
        ));
    }

    public function shortcode_dealer_dir()
    {
        $cities = $this->get_all_cities();
        $dealers = $this->get_all_dealers();

        ob_start();
        require_once(  "shortcodes/dealer_dir.php" );
        
        return ob_get_clean();
    }

    private function get_all_dealers ()
    {
        $dealers = get_posts( array (
            'numberposts' => -1, 
            'post_type' =>  'dealer_catalog',
            'post_status' => 'publish'
        ) );

        foreach( $dealers as $dealer ) {
            $city = wp_get_post_terms($dealer->ID, 'city')[0];
            $dealer->city_id = $city->term_id;
        }

        return $dealers;
    }

    private function get_all_cities ()
    {
        return get_terms( array(
            'taxonomy' => 'city',
            'hide_empty' => true,
        ) );
    }
}

if ( class_exists( 'Dealer_Catalog' ) ) {
    $dealer_catalog = new Dealer_Catalog();
}

register_activation_hook( __FILE__, array( $dealer_catalog, 'activate' ) );
register_deactivation_hook( __FILE__, array( $dealer_catalog, 'deactivate' ) );