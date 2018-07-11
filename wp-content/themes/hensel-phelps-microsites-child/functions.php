<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */


if ( ! defined('OPE_PRO_THEME_REQUIRED_PHP_VERSION')) {
    define('OPE_PRO_THEME_REQUIRED_PHP_VERSION', '5.4.0');
}

function one_page_express_unsuported_php_version()
{
    return version_compare(phpversion(), OPE_PRO_THEME_REQUIRED_PHP_VERSION, '<');
}

function one_page_express_pro_php_version_notice()
{
    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('One Page Express PRO is not working properly!', 'one-page-express'); ?></h4>
        <p>
            <?php _e('You need to update your PHP version to use the <strong>One Page Express PRO</strong>.', 'one-page-express'); ?> <br/>
            <?php _e('Current php version is:', 'one-page-express') ?> <strong>
                <?php echo phpversion(); ?></strong>, <?php _e('and the minimum required version is ', 'one-page-express') ?>
            <strong><?php echo OPE_PRO_THEME_REQUIRED_PHP_VERSION; ?></strong> <br/>
            <?php _e('Please contact your hosting provider for more information on how to update your php version.', 'one-page-express'); ?> <br/>
        </p>
    </div>
    <?php
}


function one_page_express_php_version_warning()
{
    // Compare versions.
    if (one_page_express_unsuported_php_version()) :
        // Theme not activated info message.
        add_action('admin_notices', 'one_page_express_pro_php_version_notice');
    endif;
}

add_action('admin_init', function () {
    one_page_express_php_version_warning();
});


function one_page_express_pro_require($path) {
    $path = trim($path, "\\/");
    require_once get_stylesheet_directory() ."/{$path}";
}

add_filter('cloudpress\customizer\supports', "__return_true");

require_once get_stylesheet_directory() . "/vendor/autoload.php";

require_once get_stylesheet_directory() . "/customizer/customizer.php";
require_once get_stylesheet_directory() . "/inc/utils.php";
require_once get_stylesheet_directory() . "/inc/shortcodes.php";
require_once get_stylesheet_directory() . "/inc/theme-colors.php";


require_once get_stylesheet_directory() . "/inc/multilanguage.php";


// load support for woocommerce
if (class_exists('WooCommerce')) {
    require_once get_stylesheet_directory() . "/inc/woocommerce.php";
}

require_once get_stylesheet_directory() . "/inc/theme-scss.php";

require_once 'inc/class-wp-license-manager-client.php';

if (is_admin() && ! is_customize_preview()) {
    $licence_manager = new Wp_License_Manager_Client(
        'one-page-express-pro',
        'One Page Express PRO',
        'one-page-express-pro',
        'http://onepageexpress.com/api/license-manager/v1/',
        'theme'
    );
}

if ( ! function_exists('ope_is_front_page')) {
    function ope_is_front_page()
    {
        $is_front_page = (is_front_page() && ! is_home());

        return $is_front_page;
    }
}

if ( ! function_exists('ope_is_inner_page')) {
    function ope_is_inner_page()
    {
        global $post;

        return ($post && $post->post_type === "page" && ! ope_is_front_page());
    }
}

function ope_pro_unload_kirki_fonts()
{
    return array();
}

add_filter('kirki/enqueue_google_fonts', 'ope_pro_unload_kirki_fonts');
add_action('after_switch_theme', 'ope_pro_first_activation');

function ope_pro_first_activation()
{
    $was_processed = get_option('ope_pro_first_activation_processed', false);

    if ($was_processed === false) {
        $parentOptions        = get_option('theme_mods_' . get_template(), array());
        $currentHeaderPartial = isset($parentOptions['one_page_express_header_content_partial']) ? $parentOptions['one_page_express_header_content_partial'] : "content-on-center";


        $partialParts = explode('-', $currentHeaderPartial);
        if ($partialParts[0] === "image") {
            $parentOptions['ope_header_content_media'] = "image";
        }

        if (count($partialParts) === 3) {

            if ($partialParts[0] === "image") {
                $parentOptions['ope_header_content_layout'] = "media-on-" . $partialParts[2];
            } else {
                $parentOptions['ope_header_content_layout'] = $currentHeaderPartial;
            }

        }

        $parentOptions['one_page_express_header_content_partial'] = "ope-pro-content";

        update_option('theme_mods_' . get_stylesheet(), $parentOptions);
        update_option('ope_pro_first_activation_processed', true);
    }

}


add_filter('one_page_express_theme_info_plugins', 'one_page_express_pro_theme_info_plugins');
function one_page_express_pro_theme_info_plugins($plugins)
{
    $plugins = array_merge($plugins,
        array(
            'mailchimp-for-wp' => array(
                'title'       => __('MailChimp for WordPress', 'one-page-express'),
                'description' => __('The MailChimp for WordPress plugin is recommended for the One Page Express subscribe sections.', 'one-page-express'),
                'activate'    => array(
                    'label' => __('Activate', 'one-page-express'),
                ),
                'install'     => array(
                    'label' => __('Install', 'one-page-express'),
                ),
            ),
        )
    );

    return $plugins;
}

add_filter('one_page_express_tgmpa_plugins', 'one_page_express_pro_tgmpa_plugins');
function one_page_express_pro_tgmpa_plugins($plugins)
{
    $plugins = array_merge($plugins,
        array(
            array(
                'name'     => 'MailChimp for WordPress',
                'slug'     => 'mailchimp-for-wp',
                'required' => false,
            ),
        )
    );

    return $plugins;
}

add_filter('mc4wp_form_content', 'one_page_express_mc4wp_filter');
function one_page_express_mc4wp_filter($content)
{
    $matches = array();
    preg_match_all('/<input[^>]+>/', $content, $matches);

    $email  = "";
    $submit = "";
    for ($i = 0; $i < count($matches[0]); $i++) {
        $match = $matches[0][$i];
        if (strpos($match, "email") !== false) {
            $email = $match;
        }
        if (strpos($match, "submit") !== false) {
            $submit = $match;
        }
    }

    return $email . $submit;
}

add_shortcode('one_page_express_subscribe_form', 'one_page_express_subscribe_form');
function one_page_express_subscribe_form($atts = array())
{
    ob_start();
    echo '<div class="subscribe-form">';
    if (isset($atts['shortcode'])) {
        echo do_shortcode("[" . html_entity_decode(html_entity_decode($atts['shortcode'])) . "]");
    } else {
        echo '<p style="text-align:center;">' . __('Subscribe form will be displayed here. To activate it you have to set the "subscribe form shortcode" parameter in Customizer.',
                'one-page-express-companion') . '</p>';
    }
    echo '</div>';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('one_page_express_maps', 'one_page_express_maps');
function one_page_express_maps_replace($matches)
{
    ob_start();
    echo do_shortcode($matches[0]);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function one_page_express_maps($atts = array())
{
    $content = "";

    if (isset($atts['shortcode'])) {
        $content = do_shortcode("[" . html_entity_decode(html_entity_decode($atts['shortcode'])) . "]");
    } else {
        $atts = shortcode_atts(
            array(
                'id'      => md5(uniqid("ope-map-", true)),
                'zoom'    => '65',
                'type'    => 'ROADMAP',
                'lat'     => "",
                'lng'     => "",
                'address' => "New York",
            ),
            $atts
        );

        $id = $atts['id'];


        $location     = ope_pro_maps_get_location($atts['address']);
        $atts['zoom'] = round($atts['zoom'] * 0.21);


        if ( ! is_array($location)) {
            if ($atts['lat'] && $atts['lng']) {
                $location        = array();
                $location['lat'] = $atts['lat'];
                $location['lng'] = $atts['lng'];
            } else {
                ?>
                <p style="color:red">Google Maps Error: <?php echo $location; ?> </p>
                <?php
            }
        }

        $atts['type'] = strtoupper($atts['type']);
        if (isset($location['lat'])) {
            $atts['lat'] = floatval($location['lat']);
        }
        if (isset($location['lng'])) {
            $atts['lng'] = floatval($location['lng']);
        }


        $key = get_theme_mod('one_page_express_maps_api_key', false);
        $key = (is_string($key) && ! empty($key)) ? $key : false;
        $isPreview = is_customize_preview() || apply_filters('is_shortcode_refresh', false);
        if ($key) {


            ob_start();
            ?>
            <div data-id="<?php echo $id ?>" class="ope-google-maps">
                <div class="map_content">

                </div>
                <?php if (!$isPreview) :
                    wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $key);

                    ?>
                    <script type="text/javascript">
                        jQuery(function () {
                            if (window.opeRenderMap) {
                                opeRenderMap(<?php echo json_encode($atts); ?>);
                            }
                        });
                    </script>
                <?php else: ?>
                    <script>
                        (function () {
                            var hasMapScript = (jQuery('script[src*="maps.googleapis.com/maps/"]').length > 0);

                            function renderMap() {
                                if (window.opeRenderMap) {
                                    opeRenderMap(<?php echo json_encode($atts); ?>);
                                }
                            }

                            if (!hasMapScript) {
                                var s = document.createElement('script');
                                s.type = 'text/javascript';
                                s.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>';
                                document.head.appendChild(s);

                                if (s.attachEvent) {
                                    s.attachEvent('onload', renderMap);
                                } else {
                                    s.addEventListener('load', renderMap, false);
                                }
                            } else {
                                renderMap();
                            }
                        })();
                    </script>
                <?php endif; ?>
            </div>

            <?php
            $content = ob_get_clean();
        } else {
            $content = '<p style="text-align:center;color:#ababab">Google Maps Placeholder<br>Google maps requires an api key</p>';
        }
    }


    return $content;
}

function ope_pro_maps_get_location($address, $force_refresh = false)
{

    $address_hash = md5($address);

    $coordinates = get_transient($address_hash);

    if ($force_refresh || $coordinates === false) {

        $args     = array('address' => urlencode($address), 'sensor' => 'false');
        $url      = add_query_arg($args, 'https://maps.googleapis.com/maps/api/geocode/json');


        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return null;
        }

        $data = wp_remote_retrieve_body($response);

        if (is_wp_error($data)) {
            return null;
        }

        if ($response['response']['code'] == 200) {

            $data = json_decode($data);

            if ($data->status === 'OK') {

                $coordinates = $data->results[0]->geometry->location;

                $cache_value['lat']     = $coordinates->lat;
                $cache_value['lng']     = $coordinates->lng;
                $cache_value['address'] = (string)$data->results[0]->formatted_address;

                // cache coordinates for 3 months
                set_transient($address_hash, $cache_value, 3600 * 24 * 30 * 3);
                $data = $cache_value;

            } else if ($data->status === 'ZERO_RESULTS') {
                return __('No location found for the entered address.', 'pw-maps');
            } else if ($data->status === 'INVALID_REQUEST') {
                return __('Invalid request. Did you enter an address?', 'pw-maps');
            } else {
                return __('Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'pw-maps');
            }

        } else {
            return __('Unable to contact Google API service.', 'pw-maps');
        }

    } else {
        // return cached results
        $data = $coordinates;
    }

    return $data;
}

add_action('cloudpress\companion\ready', function () {
    add_filter('ope_pro_media_type_choices', 'ope_pro_media_type_choices');
});


add_filter('cloudpress\companion\cp_data',
    function ($data, $companion) {
        $sectionsJSON = get_stylesheet_directory() . "/sections/sections.json";

        if ( ! file_exists($sectionsJSON)) {
            return $data;
        }


        $contentSections = json_decode(file_get_contents($sectionsJSON), true);
        if ($contentSections && isset($data['data']) && isset($data['data']['sections'])) {

            foreach ($contentSections as $key => $value) {
                $value['content']      = \OnePageExpress\Companion::filterDefault($value['content']);
                $contentSections[$key] = $value;
            }

            $data['data']['sections'] = array_merge($data['data']['sections'], $contentSections);
        }

        /*
        // custom section
        $customSectionContentFile = get_stylesheet_directory() . "/customizer/assets/custom-section.html";
        $customSectionContent     = file_get_contents($customSectionContentFile);

        $data['data']['sections'][] = array(
            "index"       => 1,
            "id"          => "custom-section",
            "elementId"   => "custom-section",
            "type"        => "section-available",
            "name"        => "Custom Section",
            "content"     => $customSectionContent,
            "thumb"       => "\/\/onepageexpress.com\/default-assets\/previews\/custom-section.png",
            "preview"     => "\/\/onepageexpress.com\/default-assets\/previews\/custom-section.png",
            "description" => "simple custom section",
            "category"    => "custom",
            "prepend"     => false,
            "pro"         => true,
        );*/

        $data['theme_type'] = "multipage";

        return $data;
    }, 10, 2);

add_filter('cloudpress\template\page_content',
    function ($content) {
        //$content = preg_replace_callback('/\[one_page_express_maps([^\]]*?)\]/', 'one_page_express_maps_replace', $content);
        //$content = preg_replace_callback('/\[one_page_express_subscribe_form([^\]]*)\]/', 'one_page_express_subscribe_form', $content);

        return $content;
    });
add_action('wp_enqueue_scripts', 'ope_pro_enqueue_scripts');

function ope_pro_enqueue_scripts()
{
    $theme = wp_get_theme();
    $ver   = $theme->get('Version');

    wp_enqueue_style('one-page-express-style', get_template_directory_uri() . "/style.css", array(), $ver);
    wp_enqueue_style('one-page-express-pro-style', get_stylesheet_uri(), array('one-page-express-style'), $ver);


}

add_editor_style(get_template_directory_uri() . "/style.css");
add_editor_style(get_stylesheet_uri());

add_action('init', 'ope_section_settings');
function ope_section_settings()
{

    if ( ! class_exists("\Kirki")) {
        return;
    }

    Kirki::add_field('one_page_express', array(
        'type'     => 'text',
        'settings' => 'one_page_express_maps_address',
        'label'    => __('Map address', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "New York",
    ));
    Kirki::add_field('one_page_express', array(
        'type'     => 'number',
        'settings' => 'one_page_express_maps_long',
        'label'    => __('Map Long', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "",
    ));
    Kirki::add_field('one_page_express', array(
        'type'     => 'number',
        'settings' => 'one_page_express_maps_lat',
        'label'    => __('Map Lat', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "",
    ));
    Kirki::add_field('one_page_express', array(
        'type'     => 'text',
        'settings' => 'one_page_express_maps_api_key',
        'label'    => __('Map api key', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "",
    ));
    Kirki::add_field('one_page_express', array(
        'type'     => 'text',
        'settings' => 'one_page_express_maps_shortcode',
        'label'    => __('Map plugin shortcode', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "",
    ));
    Kirki::add_field('one_page_express', array(
        'type'     => 'text',
        'settings' => 'one_page_express_subscribe_form_shortcode',
        'label'    => __('Subscribe form shortcode', 'one-page-express'),
        'section'  => 'page_content_settings',
        'default'  => "",
    ));


    Kirki::add_field('one_page_express', array(
        'type'            => 'select',
        'settings'        => 'one_page_express_header_content_partial',
        'label'           => esc_html__('Content layout', 'one-page-express'),
        'section'         => 'one_page_express_header_content',
        'default'         => 'content-on-center',
        'active_callback' => "__return_false",
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'select',
        'settings' => 'ope_header_content_layout',
        'label'    => esc_html__('Content layout', 'one-page-express'),
        'section'  => 'one_page_express_header_content',
        'default'  => 'content-on-center',
        'choices'  => array(
            "content-on-center" => __("Text on center", "one-page-express"),
            "content-on-right"  => __("Text on right", "one-page-express"),
            "content-on-left"   => __("Text on left", "one-page-express"),
            "media-on-left"     => __("Text with media on left", "one-page-express"),
            "media-on-right"    => __("Text with media on right", "one-page-express"),
            "media-on-top"      => __("Text with media above", "one-page-express"),
            "media-on-bottom"   => __("Text with media bellow", "one-page-express"),
        ),
    ));

}

add_action('init', 'ope_theme_footer');

function ope_theme_footer()
{

    if ( ! class_exists("\Kirki")) {
        return;
    }

    Kirki::add_field('one_page_express', array(

        'type'     => 'color',
        'priority' => 11,
        'settings' => 'one_page_express_footer_border_color',
        'label'    => __('Border color', 'one-page-express'),
        'section'  => 'one_page_express_footer_template',

        'default'   => "#0079AD",
        'transport' => 'postMessage',
        'choices'   => array(
            'alpha' => true,
        ),

        "output" => array(
            array(
                'element'  => '.footer',
                'property' => 'border-color',
                'suffix'   => ' !important',
            ),
            array(
                'element'  => '.footer-column-colored-1',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),

        'js_vars' => array(
            array(
                'element'  => ".footer",
                'function' => 'css',
                'property' => 'border-color',
                'suffix'   => ' !important',
            ),
            array(
                'element'  => '.footer-column-colored-1',
                'function' => 'css',
                'property' => 'background-color',
                'suffix'   => ' !important',
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'              => 'text',
        'sanitize_callback' => 'wp_kses_post',
        'priority'          => 11,
        'settings'          => 'one_page_express_footer_copyright',
        'label'             => __('Copyright', 'one-page-express'),
        'section'           => 'one_page_express_footer_template',
        'default'           => __('Built using WordPress and <a href="//onepageexpress.com">OnePage Express Theme</a>.', 'one-page-express'),
    ));


}

add_action('init', 'ope_theme_general_typo');
function ope_theme_copyright($val)
{
    $copyright = get_theme_mod('one_page_express_footer_copyright', __('Built using WordPress and <a href="//onepageexpress.com">OnePage Express Theme</a>.', 'one-page-express'));

    return $copyright;
}

add_filter("one-page-express-copyright", "ope_theme_copyright");

function ope_add_google_fonts($fonts)
{

    $fonts['Aclonica'] = array(
        "weights" => array("regular"),
    );

    $gFonts = get_theme_mod("one_page_express_web_fonts", "");
    if ($gFonts && is_string($gFonts)) {
        $gFonts = json_decode($gFonts, true);
    } else {
        $gFonts = array();
    }
    foreach ($gFonts as $font) {
        $weights = $font['weights'];
        $fam     = $font['family'];
        if (isset($fonts[$fam])) {
            $weights = array_merge($weights, $fonts[$fam]['weights']);
        }
        $fonts[$fam] = array("weights" => $weights);
    }

    return $fonts;
}

add_filter("one_page_express_google_fonts", "ope_add_google_fonts");
function ope_theme_general_typo()
{

    if ( ! class_exists("\Kirki")) {
        return;
    }

    Kirki::add_field('one_page_express', array(
        'type'     => 'repeater',
        'settings' => 'one_page_express_color_pallete',
        'label'    => esc_html__('Site Colors', 'one-page-express'),
        'section'  => "colors",
        "priority" => 0,

        'row_label' => array(
            'type'  => 'field',
            'field' => 'label',
        ),

        "fields" => array(
            "label" => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Label', 'one-page-express'),
                'default' => 'color',
            ),

            "name" => array(
                'type'    => 'hidden',
                'label'   => esc_attr__('Name', 'one-page-express'),
                'default' => 'color',
            ),

            "value" => array(
                'type'    => 'color',
                'label'   => esc_attr__('Value', 'one-page-express'),
                'default' => '#000',
            ),
        ),

        "default" => array(
            array("label" => "Primary", "name" => "color1", "value" => "#03a9f4"),
            array("label" => "Secondary", "name" => "color2", "value" => "#4caf50"),
            array("label" => "color3", "name" => "color3", "value" => "#fbc02d"),
            array("label" => "color4", "name" => "color4", "value" => "#8c239f"),
            array("label" => "color5", "name" => "color5", "value" => "#ff8c00"),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Web Fonts in site', 'one-page-express'),
        'section'  => 'general_site_style',
        'settings' => "one_page_express_web_fonts_separator",
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'web-fonts',
        'settings' => 'one_page_express_web_fonts',
        'label'    => '',
        'section'  => "general_site_style",
        'default'  => array(
            array(
                'family'  => 'Source Sans Pro',
                "weights" => array("200", "normal", "300", "600", "700"),
            ),
            array(
                'family'  => 'Playfair Display',
                "weights" => array("regular", "italic", "700", "900"),
            ),
            array(
                'family'  => 'Aclonica',
                "weights" => array("normal"),
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'     => 'sectionseparator',
        'label'    => __('Default Elements Typography', 'one-page-express'),
        'section'  => 'general_site_style',
        'settings' => "general_site_typography_separator",
    ));


    Kirki::add_field('one_page_express', array(
        'type'     => 'sidebar-button-group',
        'settings' => 'general_site_typography_group',
        'label'    => esc_attr__('General Typography', 'one-page-express-pro'),
        'section'  => 'general_site_style',
        "choices"  => array(
            'general_site_typography',
            'general_site_typography_size',
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'typography',
        'settings'  => 'general_site_typography',
        'label'     => esc_attr__('Site Typography', 'one-page-express-pro'),
        'section'   => 'general_site_style',
        'default'   => array(
            'font-family' => 'Source Sans Pro',
            'color'       => '#666666',
        ),
        'transport' => 'postMessage',
        'output'    => array(
            array(
                'element' => 'body',
            ),
        ),
        'js_vars'   => array(
            array(
                'element' => "body",
            ),
        ),
    ));

    Kirki::add_field('one_page_express', array(
        'type'      => 'slider',
        'settings'  => 'general_site_typography_size',
        'label'     => esc_attr__('Font Size', 'one-page-express-pro'),
        'section'   => 'general_site_style',
        'default'   => 18,
        'choices'   => array(
            'min'  => '12',
            'max'  => '26',
            'step' => '1',
        ),
        'output'    => array(
            array(
                'element'  => 'body',
                'property' => 'font-size',
                'units'    => 'px',
            ),
        ),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => "body",
                'function' => 'css',
                'property' => 'font-size',
                'suffix'   => 'px!important',
            ),
        ),
    ));

    $defaults = array(
        array(
            'font-size'        => "3.4em",
            'mobile-font-size' => "3.4em",
            'font-weight'      => 600,
            'text-transform'   => 'uppercase',
            'line-height'      => '115%',
            'letter-spacing'   => 'normal',
            'color'            => '#000000',
        ),
        array(
            'font-size'        => "2.7em",
            'mobile-font-size' => "2.3em",
            'font-weight'      => 300,
            'text-transform'   => 'none',
            'line-height'      => '110%',
            'letter-spacing'   => 'normal',
            'color'            => '#3D3D3D',
        ),
        array(
            'font-size'        => "2.2em",
            'mobile-font-size' => "1.44em",
            'font-weight'      => 600,
            'text-transform'   => 'none',
            'line-height'      => '115%',
            'letter-spacing'   => 'normal',
            'color'            => '#333333',
        ),
        array(
            'font-size'        => "1.11em",
            'mobile-font-size' => "1.11em",
            'font-weight'      => 600,
            'text-transform'   => 'none',
            'line-height'      => '150%',
            'letter-spacing'   => 'normal',
            'color'            => '#333333',
        ),
        array(
            'font-size'        => "1em",
            'mobile-font-size' => "1em",
            'font-weight'      => 600,
            'text-transform'   => 'none',
            'line-height'      => '150%',
            'letter-spacing'   => '2px',
            'color'            => '#333333',
        ),
        array(
            'font-size'        => "1em",
            'mobile-font-size' => "1em",
            'font-weight'      => 400,
            'text-transform'   => 'uppercase',
            'line-height'      => '100%',
            'letter-spacing'   => '3px',
            'color'            => '#B5B5B5',
        ),
    );
    for ($i = 0; $i < 6; $i++) {
        $el = "h" . ($i + 1);

        Kirki::add_field('one_page_express', array(
            'type'     => 'sidebar-button-group',
            'settings' => 'general_site_' . $el . '_typography_group',
            'label'    => esc_attr__(strtoupper($el) . ' Typography', 'one-page-express-pro'),
            'section'  => 'general_site_style',
            "choices"  => array(
                'general_site_' . $el . '_typography',
            ),
        ));

        Kirki::add_field('one_page_express', array(
            'type'      => 'typography',
            'settings'  => 'general_site_' . $el . '_typography',
            'label'     => esc_attr__(strtoupper($el) . ' Typography', 'one-page-express-pro'),
            'section'   => 'general_site_style',
            'default'   => array_merge($defaults[$i], array(
                'font-family' => 'Source Sans Pro',
            )),
            'transport' => 'postMessage',
            'output'    => array(
                array(
                    'element' => 'body ' . $el,
                ),
            ),
            'js_vars'   => array(
                array(
                    'element' => "body " . $el,
                ),
            ),
        ));
    }

}

add_action('init', 'load_ope_options_files');


function load_ope_options_files()
{
    if ( ! class_exists("\Kirki")) {
        return;
    }

    require_once get_stylesheet_directory() . "/inc/pluggable.php";
    require_once get_stylesheet_directory() . "/inc/navigation-options.php";
    require_once get_stylesheet_directory() . "/inc/header-options.php";
    require_once get_stylesheet_directory() . "/inc/multiple-buttons-options.php";
    require_once get_stylesheet_directory() . "/inc/general-options.php";
}


function ope_pro_print_header_video()
{
    $video   = get_theme_mod('ope_pro_header_content_video', 'https://www.youtube.com/watch?v=3iXYciBTQ0c');
    $embed   = new WP_Embed();
    $content = $embed->shortcode(array(), $video);

    $content = preg_replace('/width="\d+"/', "", $content);
    $content = preg_replace('/height="\d+"/', 'class="ope-header-video"', $content);

    $class = "";

    if (strpos($content, '<iframe') !== false) {
        $class = "iframe-holder ";
    }

    echo '<div class="content-video-container ' . $class . '">' . $content . '</div>';
}

function ope_pro_print_header_video_popup()
{

    $url   = get_theme_mod('ope_pro_header_content_video', 'https://www.youtube.com/watch?v=3iXYciBTQ0c');
    $style = "";

    $image    = get_theme_mod('one_page_express_header_video_popup_image', get_template_directory_uri() . "/assets/images/Mock-up.jpg");
    $disabled = get_theme_mod('one_page_express_header_video_popup_image_disabled', false);

    if (intval($disabled)) {
        $image = false;
    }

    ob_start();
    ?>
    <div class="video-popup-button <?php echo ($image) ? 'with-image' : '' ?>">
        <?php if ($image): ?>
            <img class="poster" src="<?php echo $image ?>"/>
        <?php endif; ?>
        <a class="video-popup-button-link" data-fancybox data-video-lightbox="true" href="<?php echo $url ?>">
            <i class="fa fa-play-circle-o"></i>
        </a>
    </div>
    <?php
    echo ob_get_clean();
}


add_shortcode('ope_embed_url', 'ope_embed_url');

function ope_pro_print_header_section_content($mod_part)
{
    $mod     = "ope_pro_header_section_content_{$mod_part}";
    $content = get_theme_mod($mod, false);

    if ($content === false || ! trim($content)) {
        $companion = \OnePageExpress\Companion::instance();
        $sections  = $companion->getCustomizerData("data:sections");


        foreach ($sections as $section) {
            if ($section['id'] === $mod_part) {
                $content = $section['content'];
                $content = \OnePageExpress\Companion::filterDefault($content);
                break;
            }
        }
    }

    ?>
    <div class="header-section-content" data-theme="<?php echo $mod; ?>">
        <?php echo $content; ?>
    </div>
    <?php
}


function ope_pro_print_header_media()
{
    $mediaType = get_theme_mod('ope_header_content_media', 'image');

    switch ($mediaType) {
        case "image":
//            one_page_express_print_header_image();
            $round        = get_theme_mod('one_page_express_header_content_image_rounded', false);
            $extraClasses = "";
            if (intval($round)) {
                $extraClasses .= " round";
            }

            $image = get_theme_mod('one_page_express_header_content_image', get_template_directory_uri() . "/assets/images/project1.jpg");
            if ( ! empty($image)) {
                printf('<img class="homepage-header-image %2$s" src="%1$s"/>', esc_url($image), $extraClasses);
            }
            break;

        case "video":
            ope_pro_print_header_video();
            break;

        case "video_popup":
            ope_pro_print_header_video_popup();
            break;

        default:
            $functionName    = "one_page_express_print_{$mediaType}";
            $proFunctionName = "ope_pro_print_{$mediaType}";
            if (function_exists($functionName)) {
                call_user_func($functionName);
            } else {
                if (function_exists($proFunctionName)) {
                    call_user_func($proFunctionName);
                }
            }

            if (strpos($mediaType, "header_contents|") === 0) {
                $mod_part = str_replace("header_contents|", "", $mediaType);
                ope_pro_print_header_section_content($mod_part);
            }
    }
}

function ope_embed_url($atts, $content = "")
{

    if ( ! $content) {
        return "";
    }

    $embed = new WP_Embed();

    $content = $embed->shortcode(array("autoplay" => "on"), $content);

    $matches = array();
    preg_match('/src="(.*?)"/', $content, $matches);


    if (count($matches) === 2) {
        $content = $matches[1];
    } else {

        // maybe link
        $matches = array();
        preg_match('/href="(.*?)"/', $content, $matches);
        if (count($matches) === 2) {
            $content = $matches[1];
        } else {
            $content = "";
        }
    }

    return esc_url_raw($content);
}

add_action('cloudpress\template\load_assets', 'ope_pro_maintainable_load_assets');


function ope_pro_maintainable_load_assets()
{

    $theme = wp_get_theme();
    $ver   = $theme->get('Version');

    wp_enqueue_style('one-page-express-pro-content', get_stylesheet_directory_uri() . "/sections/content.css", array('one-page-express-pro-style'), $ver);
    $key = get_theme_mod('one_page_express_maps_api_key', "");
    wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $key);
    wp_enqueue_script('one-page-express-pro', get_stylesheet_directory_uri() . "/assets/js/scripts.js", array(), $ver);

    wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . "/assets/css/jquery.fancybox.min.css", array(), $ver);
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . "/assets/js/jquery.fancybox.min.js", array("jquery"), $ver);
}


// header buttons

if ( ! function_exists('one_page_express_print_header_button_1')) {
    function one_page_express_print_header_button_1()
    {
        $title = get_theme_mod('one_page_express_header_btn_1_label', "");
        $url   = get_theme_mod('one_page_express_header_btn_1_url', '#');

        $target = get_theme_mod('one_page_express_header_btn_1_target', '_self');
        $class  = get_theme_mod('one_page_express_header_btn_1_class', 'button hp-header-primary-button blue big');

        $show = get_theme_mod('one_page_express_header_show_btn_1', true);

        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 1', 'one-page-express');
            }
        }
        if ($show && $title) {
            printf('<a class="%4$s" target="%3$s" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title), $target, $class);
        }
    }

}

if ( ! function_exists('one_page_express_print_header_button_2')) {
    function one_page_express_print_header_button_2()
    {
        $title = get_theme_mod('one_page_express_header_btn_2_label', "");
        $url   = get_theme_mod('one_page_express_header_btn_2_url', '#');
        $show  = get_theme_mod('one_page_express_header_show_btn_2', true);

        $target = get_theme_mod('one_page_express_header_btn_2_target', '_self');
        $class  = get_theme_mod('one_page_express_header_btn_2_class', 'button hp-header-secondary-button big green');

        if (current_user_can('edit_theme_options')) {
            if (empty($title)) {
                $title = __('Action button 2', 'one-page-express');
            }
        }

        if ($show && $title) {
            printf('<a  class="%4$s" target="%3$s" href="%1$s">%2$s</a>', esc_url($url), wp_kses_post($title), $target, $class);
        }
    }
}


// autosetting functions

add_filter('option_theme_mods_' . get_stylesheet(), function ($values) {
    if (is_customize_preview()) {
        global $wp_customize;
        $settings = $wp_customize->unsanitized_post_values();

        foreach ($settings as $mod => $value) {
            if (strpos($mod, "CP_AUTO_SETTING[") === 0) {
                $key = str_replace("CP_AUTO_SETTING[", "", $mod);
                $key = trim($key, "[]");

                $values[$key] = $value;
            }
        }
    }

    return $values;
});


function ope_print_stores_badges()
{
    $stores = get_theme_mod('ope_store_badges', array(
        array(
            'store' => 'google-store',
            'link'  => '#',
        ),
        array(
            'store' => 'apple-store',
            'link'  => '#',
        ),
    ));

    $locale = get_locale();
    $locale = explode('_', $locale);
    $locale = $locale[0];
    $locale = strtolower($locale);


    $imgRoot = get_stylesheet_directory() . "/assets/images/store-badges";


    foreach ($stores as $storeData) {

        $store = $storeData['store'];
        $link  = $storeData['link'];

        $imgPath = "{$imgRoot}/{$store}";

        if ($store === "apple-store") {

            $img = $imgPath . "/download_on_the_app_store_badge_{$locale}_135x40.svg";

            if ( ! file_exists($img)) {
                $img = $imgPath . "/download_on_the_app_store_badge_en_135x40.svg";
            }

            $imgPath = $img;
        }

        if ($store === "google-store") {
            $img = $imgPath . "/{$locale}_badge_web_generic.svg";

            if ( ! file_exists($img)) {
                $img = $imgPath . "/en_badge_web_generic.svg";
            }

            $imgPath = $img;
        }


        $imgData = file_get_contents($imgPath);

        if ($store === "google-store") {
            $imgData = str_replace('viewBox="0 0 155 60"', 'viewBox="10 10 135 40"', $imgData);
//

        }

        $imgData = preg_replace('/width="\d+px"/', '', $imgData);
        $imgData = preg_replace('/height="\d+px"/', '', $imgData);

        printf('<a class="badge-button button %3$s" target="_blank" href="%1$s">%2$s</a>', esc_url($link), $imgData, $store);

    }

}


function one_page_express_print_header_subtitle2()
{
    $subtitle = get_theme_mod('one_page_express_header_subtitle2', false);
    $show     = get_theme_mod('one_page_express_header_show_subtitle2', false);

    $subtitle = one_page_express_parse_eff($subtitle);

    if (current_user_can('edit_theme_options')) {
        if ($subtitle === false) {
            $subtitle = __('You can set this subtitle from the customizer.', 'one-page-express');
        }
    }
    if ($show) {
        printf('<p class="header-subtitle2">%1$s</p>', $subtitle);
    }
}


// override header content function

if ( ! function_exists("one_page_express_print_header_content")) {
    function one_page_express_print_header_content()
    {
        one_page_express_print_header_subtitle2();
        one_page_express_print_header_title();
        one_page_express_print_header_subtitle();


        $buttonsType = get_theme_mod('ope_pro_header_buttons_type', 'normal');

        echo '<div class="header-buttons-wrapper">';
        switch ($buttonsType) {
            case "normal":
                one_page_express_print_header_button_1();
                one_page_express_print_header_button_2();
                break;

            case "multiple_buttons":
                one_page_express_pro_buttons_list_print();
                break;

            case "store":
                ope_print_stores_badges();
                break;
        }
        echo '</div>';
    }
}

// arrow

function one_page_express_bottom_arrow()
{
    $show   = get_theme_mod('one_page_express_header_show_bottom_arrow', false);
    $bounce = get_theme_mod('one_page_express_header_bounce_bottom_arrow', true);

    $class = "header-homepage-arrow ";

    if ($bounce) {
        $class .= "move-down-bounce";
    }

    if ($show) {
        $icon = get_theme_mod('one_page_express_header_bottom_arrow', "fa-chevron-down");
        ?>
        <div class="header-homepage-arrow-c">
            <span class="<?php echo $class ?>"> <i class="fa arrow <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
            </span>
        </div>
        <?php
    }
}

add_action('one_page_express_after_header_content', 'one_page_express_bottom_arrow');


// remove sections that are not in page content;

add_filter('cloudpress\customizer\control\content_sections\data', 'ope_pro_header_content_section', PHP_INT_MAX);


function ope_pro_header_content_section($data)
{

    unset($data['header-contents']);

    return $data;
}


add_filter('one_page_express_header_background_atts', 'one_page_express_pro_header_background_atts');

function one_page_express_pro_header_background_atts($atts)
{

    if ( ! isset($atts['class'])) {
        $atts['class'] = "";
    }

    $valign = get_theme_mod('header_content_vertical_align', 'v-align-top');

    $atts['class'] .= " " . $valign;

    return $atts;
}

add_filter('one_page_express_header_background_atts', 'one_page_express_pro_inner_header_custom_image', 10, 3);

function one_page_express_pro_inner_header_custom_image($atts, $bgType, $inner)
{
    global $post;
    if ($inner && $bgType === "image" && $post) {
        $show_thumbnail_image = apply_filters('ope_pro_override_with_thumbnail_image', $post->post_type === "page");
        if ($show_thumbnail_image) {
            $thumbnail = get_the_post_thumbnail_url($post->ID,'one-page-express-full-hd');
            if ($thumbnail) {
                $atts['style'] = 'background-image:url("' . $thumbnail . '")';
            }
        }
    }

    return $atts;
}


add_filter('theme_mod_one_page_express_header_content_partial', 'theme_mod_one_page_express_header_content_partial');

function theme_mod_one_page_express_header_content_partial($result)
{

    $result = "ope-pro-content";

    return $result;
}

add_filter('theme_mod_header_content_text_vertical_align', 'theme_mod_header_content_text_vertical_align');

function theme_mod_header_content_text_vertical_align($result)
{

    switch ($result) {
        case "top":
            $result = "flex-start";
            break;

        case "middle":
            $result = "center";
            break;

        case "bottom":
            $result = "flex-end";
            break;
    }


    return $result;
}


function one_page_express_header_content_align()
{
    $align = get_theme_mod("one_page_express_header_text_align", "center");
    echo "container-align-" . $align;
}

add_filter('one_page_express_header_presets', 'one_page_express_header_presets_pro');


add_filter('one_page_express_header_description_classes', function ($classes) {

    $pro_part = get_theme_mod('ope_header_content_layout', 'content-on-center');

    return $classes . " " . $pro_part;
});

function one_page_express_header_presets_pro($result)
{
    $file  = get_stylesheet_directory() . "/inc/header-presets.php";
    $toAdd = array();
    if (file_exists($file)) {
        $toAdd = require($file);
    }

    return array_merge($result, $toAdd);
}

add_action('wp_head', 'ope_pro_custom_style', PHP_INT_MAX);


function ope_sprintf_style_array($data, $media = false)
{
    $style = "";

    if ( ! is_array($data) || empty($data)) {
        return $style;
    }

    foreach ($data as $selector => $props) {
        $propsText = "";
        foreach ($props as $prop => $value) {
            $propText = "\t{$prop}:{$value};\n";
            if ($media) {
                $propText = "\t{$propText}";
            }
            $propsText .= $propText;
        }

        if ($media) {
            $selector = "\t{$selector}";
        }

        $style .= "$selector{\n{$propsText}\n}";
    }

    if ($media) {
        $style = "$media{\n{$style}\n}";
    }

    return $style . "\n";

}

function ope_pro_custom_style()
{
    ope_theme_print_colors();

    global $post;

    if ( ! $post) {
        return;
    }

    $mediaMap = array(
        "mobile"  => "@media screen and (max-width:767)",
        "tablet"  => "@media screen and (min-width:768)",
        "desktop" => "@media screen and (min-width:1024)",
        "nomedia" => false,
    );

    $mod  = 'ope_pro_custom_style_' . $post->ID;
    $data = get_theme_mod($mod, array(
        "mobile"  => array(),
        "tablet"  => array(),
        "desktop" => array(),
        "nomedia" => array(),
    ));

    $outputOrder = array('nomedia', 'mobile', 'tablet', 'desktop');

    $style = "";
    foreach ($outputOrder as $media) {
        $mediaQuery  = $mediaMap[$media];
        $mediaStyles = isset($data[$media]) ? $data[$media] : array();
        $style       .= ope_sprintf_style_array($mediaStyles, $mediaQuery);
    }

    ?>
    <style id="ope-pro-page-custom-styles">
        <?php echo $style; ?>
    </style>
    <?php
}


add_filter('cloudpress\customizer\preview_data', 'ope_pro_page_custom_styles_filter');

function ope_pro_page_custom_styles_filter($value)
{

    global $post;

    if ($post) {
        $mod  = 'ope_pro_custom_style_' . $post->ID;
        $data = get_theme_mod($mod, array(
            "mobile"  => new stdClass(),
            "tablet"  => new stdClass(),
            "desktop" => new stdClass(),
            "nomedia" => new stdClass(),
        ));

        $value['content_style'] = $data;
    }

    $widgets_areas_mod = get_theme_mod('ope_pro_users_custom_widgets_areas', array());
    $widgets_areas     = array();

    foreach ($widgets_areas_mod as $index => $data) {
        $id                 = "ope_pro_users_custom_widgets_area_{$index}";
        $widgets_areas[$id] = $data['name'];
    }

    $value['widgets_areas'] = $widgets_areas;

    return $value;
}


function one_page_express_user_custom_widgets_init()
{
    $widgets_area = get_theme_mod('ope_pro_users_custom_widgets_areas', array());

    foreach ($widgets_area as $id => $data) {
        register_sidebar(array(
            'name'          => $data['name'],
            'id'            => "ope_pro_users_custom_widgets_area_{$id}",
            'title'         => "Widget Area",
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ));
    }

}

add_action('widgets_init', 'one_page_express_user_custom_widgets_init');

add_filter('ope_show_post_meta', function ($value) {

    $can_show = get_theme_mod('ope_show_post_meta', true);

    return (1 === intval($can_show));

});


if ( ! function_exists('ope_print_navigation')) {
    function ope_print_navigation()
    {
        $prefix  = ope_is_inner_page() ? "inner_" : "";
        $default = get_theme_mod('navigation_bar', 'default');

        $navigationPartial = apply_filters('ope_navigation_bar', $default);

        get_template_part("/template-parts/navigation/{$navigationPartial}");
    }
}


function one_page_express_is_woocommerce()
{
    return function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());
}

function one_page_express_is_woocommerce_product_page()
{
    return function_exists('is_woocommerce') && is_product();
}
