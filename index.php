<?php

/**
 * elasticpress-type-boost
 *
 * @package       EPTB
 * @author        Damon Brown
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   ElasticPress Type Boost
 * Plugin URI:    https://github.com/trietopsoft/elasticpress-type-boost
 * Description:   ElasticPress Type Boost
 * Version:       1.0.0
 * Author:        Damon Brown
 * Author URI:    https://www.trietop.com
 * Text Domain:   elasticpress-type-boost
 * Domain Path:   /languages
 */

function load_elasticpress_type_boost()
{
    if (class_exists('\ElasticPress\Features')) {
        // Include your class file.
        require 'elasticpress-type-boost.php';
        // Register your feature in ElasticPress.
        \ElasticPress\Features::factory()->register_feature(
            new ElasticPress_Type_Boost()
        );
    }
}
add_action('plugins_loaded', 'load_elasticpress_type_boost', 11);