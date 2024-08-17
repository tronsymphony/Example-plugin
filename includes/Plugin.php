<?php

namespace Literati\Example;

use Literati\Example\Blocks;
use Literati\Example\Meta;

/**
 * Main plugin class.
 */
class Plugin {
  /**
   * Plugin version.
   */
  private $version = '1.0.0';

  /**
   * The single instance of the class.
   */
  protected static $_instance = null;

  /**
   * Main LITERATI_EXAMPLE instance. Ensures only one instance is loaded or can be loaded'.
   */
  public static function instance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * Cloning is forbidden.
   */
  public function __clone() {
    _doing_it_wrong(
      __FUNCTION__,
      esc_html__('Foul!', 'literati-example'),
      '1.0.0'
    );
  }

  /**
   * Unserializing instances of this class is forbidden.
   */
  public function __wakeup() {
    _doing_it_wrong(
      __FUNCTION__,
      esc_html__('Foul!', 'literati-example'),
      '1.0.0'
    );
  }

  /**
   * Construct
   */
  protected function __construct() {
    // Entry point.
    $this->initialize_plugin();
  }

  /**
   * Get Plugin URL
   */
  public function get_plugin_url() {
    return untrailingslashit(plugins_url('/', __DIR__));
  }

  /**
   * Get Plugin Path
   */
  public function get_plugin_path() {
    return untrailingslashit(plugin_dir_path(__DIR__));
  }

  /**
   * Get Plugin Basename
   */
  public function get_plugin_basename() {
    return plugin_basename(__DIR__);
  }

  /**
   * Get Plugin Version
   */
  public function get_plugin_version($base = false, $version = '') {
    $version = $version ? $version : $this->version;

    if ($base) {
      $version_parts = explode('-', $version);
      $version = count($version_parts) > 1 ? $version_parts[0] : $version;
    }

    return $version;
  }

  /**
   * Define constants
   */
  protected function maybe_define_constant($name, $value) {
    if (!defined($name)) {
      define($name, $value);
    }
  }

  /**
   * Indicates whether the plugin is fully initialized.
   */
  public function is_plugin_initialized() {
    return null !== $this->get_plugin_version();
  }

  /**
   * Initialize
   */
  public function initialize_plugin() {
    $this->define_constants();
    $this->includes();
    add_action('init', array($this, 'create_promotion_post_type'));
    new Meta();
  }

  /**
   * Constants.
   */
  public function define_constants() {
    $this->maybe_define_constant('LITERATI_EXAMPLE_VERSION', $this->version);
    $this->maybe_define_constant(
      'LITERATI_EXAMPLE_ABSPATH',
      trailingslashit(plugin_dir_path(__DIR__))
    );
  }

  /**
   * Includes.
   */
  public function includes() {
    Blocks::init();
  }

  public function create_promotion_post_type() {
      $labels = array(
          'name'               => __( 'Promotions' ),
          'singular_name'      => __( 'Promotion' ),
          'add_new'            => __( 'Add New Promotion' ),
          'add_new_item'       => __( 'Add New Promotion' ),
          'edit_item'          => __( 'Edit Promotion' ),
          'new_item'           => __( 'New Promotion' ),
          'view_item'          => __( 'View Promotion' ),
          'search_items'       => __( 'Search Promotions' ),
          'not_found'          => __( 'No Promotions found' ),
          'not_found_in_trash' => __( 'No Promotions found in Trash' ),
          'menu_name'          => __( 'Promotions' ),
      );

      $args = array(
          'labels'             => $labels,
          'public'             => true,
          'publicly_queryable' => true,
          'show_ui'            => true,
          'show_in_menu'       => true,
          'show_in_rest'       => true,
          'query_var'          => true,
          'rewrite'            => array( 'slug' => 'promotion' ),
          'capability_type'    => 'post',
          'has_archive'        => true,
          'hierarchical'       => false,
          'menu_position'      => null,
          'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
      );

      register_post_type( 'promotion', $args );
  }

  /**
   * Uninstall methods
   */
  public static function uninstall() {
    // Uninstall
  }
}
