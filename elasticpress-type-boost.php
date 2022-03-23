<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

use ElasticPress\Feature as Feature;

/**
 * ElasticPress Type Boost
 */
class ElasticPress_Type_Boost extends Feature
{

    /**
     * Initialize feature settings.
     */
    public function __construct()
    {
        $this->slug = 'elasticpress_type_boost';

        $this->title = esc_html__('Type Boost', 'elasticpress');

        $this->requires_install_reindex = false;
        $this->default_settings         = [
            'type_boost' => false,
            'type_boost_post' => 1,
            'type_boost_page' => 1,
            'type_boost_insights' => 1,
            'type_boost_capabilities' => 1,
            'type_boost_products' => 1,
            'type_boost_sectors' => 1,
            'type_boost_events' => 1,
            'type_boost_locations' => 1,
            'type_boost_people' => 5,
            'type_boost_transactions' => 1
        ];

        parent::__construct();
    }

    /**
     * We need to delay search setup up since it will fire after protected content and protected
     * content filters into the search setup
     *
     * @since 2.2
     */
    public function setup()
    {
        add_action('init', [$this, 'type_setup']);
    }

    /**
     * Setup feature on each page load
     *
     * @since  3.0
     */
    public function type_setup()
    {
        add_filter('ep_formatted_args', [$this, 'boost_types'], 20, 2);
    }

    /**
     * Returns true/false if type boosting is/isn't enabled
     *
     * @return bool
     */
    public function is_type_boost()
    {
        $settings = $this->get_settings();

        $settings = wp_parse_args(
            $settings,
            [
                'type_boost' => false
            ]
        );

        return (bool) $settings['type_boost'];
    }

    /**
     * Output feature box summary.
     */
    public function output_feature_box_summary()
    {
?>
        <p><?php esc_html_e('Type Boost', 'elasticpress'); ?></p>
    <?php
    }

    /**
     * Output feature box long
     */
    public function output_feature_box_long()
    {
    ?>
        <p><?php esc_html_e('Enable type boost for ElasticPress', 'elasticpress'); ?></p>
    <?php
    }


    /**
     * Display field settings on the Dashboard.
     */
    public function output_feature_box_settings()
    {
        $settings = $this->get_settings();

        if (!$settings) {
            $settings = [];
        }

        $settings = wp_parse_args($settings, $this->default_settings);

    ?>
        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Boost Types', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_enabled"><input name="type_boost_enabled" id="type_boost_enabled" data-field-name="type_boost" class="setting-field" type="radio" <?php if ((bool) $settings['type_boost']) : ?>checked<?php endif; ?> value="1"><?php esc_html_e('Enabled', 'elasticpress'); ?></label><br>
                <label for="type_boost_disabled"><input name="type_boost_enabled" id="type_boost_disabled" data-field-name="type_boost" class="setting-field" type="radio" <?php if (!(bool) $settings['type_boost']) : ?>checked<?php endif; ?> value="0"><?php esc_html_e('Disabled', 'elasticpress'); ?></label>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Post Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_post"><input name="type_boost_post" id="type_boost_post" data-field-name="type_boost_post" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_post']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Page Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_page"><input name="type_boost_page" id="type_boost_page" data-field-name="type_boost_page" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_page']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Insights Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_insights"><input name="type_boost_insights" id="type_boost_insights" data-field-name="type_boost_insights" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_insights']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Capabilities Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_capabilities"><input name="type_boost_capabilities" id="type_boost_capabilities" data-field-name="type_boost_capabilities" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_capabilities']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Products Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_products"><input name="type_boost_products" id="type_boost_products" data-field-name="type_boost_products" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_products']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Sectors Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_sectors"><input name="type_boost_sectors" id="type_boost_sectors" data-field-name="type_boost_sectors" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_sectors']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Events Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_events"><input name="type_boost_events" id="type_boost_events" data-field-name="type_boost_events" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_events']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Locations Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_locations"><input name="type_boost_locations" id="type_boost_locations" data-field-name="type_boost_locations" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_locations']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('People Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_people"><input name="type_boost_people" id="type_boost_people" data-field-name="type_boost_people" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_people']); ?>"></label><br>
            </div>
        </div>

        <div class="field js-toggle-feature" data-feature="<?php echo esc_attr($this->slug); ?>">
            <div class="field-name status"><?php esc_html_e('Transactions Boost', 'elasticpress'); ?></div>
            <div class="input-wrap">
                <label for="type_boost_transactions"><input name="type_boost_transactions" id="type_boost_transactions" data-field-name="type_boost_transactions" class="setting-field" type="number" min="0" max="9999999999" value="<?php echo htmlspecialchars($settings['type_boost_transactions']); ?>"></label><br>
            </div>
        </div>
<?php
    }

    /**
     * Boost types in search
     *
     * @param  array $formatted_args Formatted ES args
     * @param  array $args WP_Query args
     * @since  2.1
     * @return array
     */
    public function boost_types($formatted_args, $args)
    {
        if (!empty($args['s'])) {
            if ($this->is_type_boost()) {

                $settings = $this->get_settings();
                if (array_key_exists('function_score', $formatted_args['query']) && array_key_exists('functions', $formatted_args['query']['function_score'])) {
                    /**
                     * Apply boost
                     */
                    $type_boost = array(
                        'script_score' => array(
                            'script' => array(
                                'lang' => apply_filters('script_score_lang', 'painless', $formatted_args, $args),
                                'source' => apply_filters('script_score_inline', "if (params._source.containsKey('post_type')) { return params[params._source['post_type']] * _score;} else { return _score;}", $formatted_args, $args),
                                'params' => array(
                                    'post' => apply_filters('type_boost_post', floatval($settings['type_boost_post']), $formatted_args, $args),
                                    'page' => apply_filters('type_boost_page', floatval($settings['type_boost_page']), $formatted_args, $args),
                                    'insights' => apply_filters('type_boost_insights', floatval($settings['type_boost_insights']), $formatted_args, $args),
                                    'capabilities' => apply_filters('type_boost_capabilities', floatval($settings['type_boost_capabilities']), $formatted_args, $args),
                                    'products' => apply_filters('type_boost_products', floatval($settings['type_boost_products']), $formatted_args, $args),
                                    'sectors' => apply_filters('type_boost_sectors', floatval($settings['type_boost_sectors']), $formatted_args, $args),
                                    'events' => apply_filters('type_boost_events', floatval($settings['type_boost_events']), $formatted_args, $args),
                                    'locations' => apply_filters('type_boost_locations', floatval($settings['type_boost_locations']), $formatted_args, $args),
                                    'people' => apply_filters('type_boost_people', floatval($settings['type_boost_people']), $formatted_args, $args),
                                    'transactions' => apply_filters('type_boost_transactions', floatval($settings['type_boost_transactions']), $formatted_args, $args)
                                )
                            )
                        )
                    );


                    array_push($formatted_args['query']['function_score']['functions'], $type_boost);
                }
            }
        }

        return $formatted_args;
    }
}
