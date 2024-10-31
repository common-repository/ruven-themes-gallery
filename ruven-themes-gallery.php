<?php
/*
Plugin Name: Ruven Themes: Gallery
Description: Extends the functionality of Ruven Themes by adding a Gallery post type
Version: 1.0
Author: Ruven
Author URI: http://ruventhemes.com/
Author Email: info@ruventhemes.com
*/






/* Initialize Gallery
============================================================ */

if(!class_exists('rt_gallery')):

  class rt_gallery {



    /* Constructor
    ------------------------------------------------------------ */

    function __construct()
    {
      // Portfolio Post Type
      add_action('init', array(&$this, 'register_post_type'));

      // Portfolio Taxonomy
      if(!get_option('rtg_disable_gallery_tax_category')) {
        add_action('init', array(&$this, 'register_taxonomy_category'));
      }

      // Run when the plugin is activated
      register_activation_hook(__FILE__, array($this, 'plugin_activation'));

      // Load plugin text domain (for translation)
      add_action('plugins_loaded', array($this, 'load_textdomain'));
    }



    /* Plugin Activation
    ------------------------------------------------------------ */

    function plugin_activation()
    {
      flush_rewrite_rules();
    }



    /* Load plugin text domain (for translation)
    ------------------------------------------------------------ */

    function load_textdomain()
    {
      load_plugin_textdomain('ruventhemes', false, dirname(plugin_basename(__FILE__)).'/lang');
    }



    /* Register Gallery Post Type
    ------------------------------------------------------------ */

    function register_post_type()
    {
      $labels = apply_filters('rt_gallery_labels', array(
        'name'               => _x('Galleries', 'post type name', 'ruventhemes'),
        'singular_name'      => _x('Gallery', 'singular post type name', 'ruventhemes'),
        'add_new'            => _x('Add New', 'gallery', 'ruventhemes'),
        'add_new_item'       => __('Add New Gallery', 'ruventhemes'),
        'edit_item'          => __('Edit Gallery', 'ruventhemes'),
        'new_item'           => __('New Gallery', 'ruventhemes'),
        'view_item'          => __('View Gallery', 'ruventhemes'),
        'search_items'       => __('Search Galleries', 'ruventhemes'),
        'not_found'          => __('No gallery found', 'ruventhemes'),
        'not_found_in_trash' => __('No gallery found in trash', 'ruventhemes'),
        'parent_item_colon'  => ''
      ));

      $args = apply_filters('rt_gallery_args', array(
        'labels'              => $labels,
        'public'              => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => false,
        'supports'            => array(
                                   'title',
                                   'editor',
                                   'post-formats',
                                   'thumbnail',
                                   'revisions',
                                   'excerpt',
                                   'comments',
                                   'author',
                                   'custom-fields',
                                 ),
        'rewrite'             => array('slug' => _x('gallery-item', 'URL slug (no spaces or special characters)', 'ruventhemes')),
        'menu_position'       => 5,
        'has_archive'         => true,
      ));

      register_post_type('gallery', $args);
    }



    /* Register Taxonomy: Category
    ------------------------------------------------------------ */

    function register_taxonomy_category()
    {
      $labels = apply_filters('rt_gallery_tax_labels', array(
        'name'                       => _x('Gallery Categories', 'post type name', 'ruventhemes'),
        'singular_name'              => _x('Gallery Category', 'singular post type name', 'ruventhemes'),
        'menu_name'                  => __('Categories', 'ruventhemes' ),
        'edit_item'                  => __('Edit Gallery Category', 'ruventhemes'),
        'update_item'                => __('Update Gallery Category', 'ruventhemes'),
        'add_new_item'               => __('Add New Gallery Category', 'ruventhemes'),
        'new_item_name'              => __('New Gallery Category Name', 'ruventhemes'),
        'parent_item'                => __('Parent Gallery Category', 'ruventhemes'),
        'parent_item_colon'          => __('Parent Gallery Category:', 'ruventhemes'),
        'all_items'                  => __('All Gallery Categories', 'ruventhemes'),
        'search_items'               => __('Search Gallery Categories', 'ruventhemes'),
        'popular_items'              => __('Popular Gallery Categories', 'ruventhemes'),
        'separate_items_with_commas' => __('Separate gallery categories with commas', 'ruventhemes'),
        'add_or_remove_items'        => __('Add or remove gallery categories', 'ruventhemes'),
        'choose_from_most_used'      => __('Choose from the most used gallery categories', 'ruventhemes'),
        'not_found'                  => __('No gallery categories found.', 'ruventhemes'),
      ));

      $args = apply_filters('rt_gallery_tax_args', array(
        'labels'            => $labels,
        'public'            => true,
        'query_var'         => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'rewrite'           => array(
                                 'slug' => _x('gallery-category', 'URL slug (no spaces or special characters)', 'ruventhemes'),
                                 'hierarchical' => true
                               ),
      ));

      register_taxonomy('gallery-category', 'gallery', $args);
    }



  }







  /* Invoke Gallery
  ============================================================ */

  new rt_gallery();


endif;