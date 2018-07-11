<?php

add_action('wp_ajax_compiled_style_preview', 'ope_pro_get_compiled_style_preview');

function ope_pro_get_scss_vars()
{
    $result     = one_page_express_get_colors();
    $typography = ope_pro_vars_typography();
    $result     = array_merge($result, $typography);

    $result = apply_filters('ope_pro_scss_vars', $result);


    return $result;
}

function ope_pro_get_scss_entry_array($varsOverride = array())
{
    $scssFiles = array(
        'Base',
        'Form',
    );
    $isAjax    = function_exists('is_ajax') ? is_ajax() : false;
    $scssFiles = apply_filters('ope_pro_scss_files', $scssFiles, $isAjax);
    $scssFiles = array_unique($scssFiles);

    $vars = ope_pro_get_scss_vars();

    $vars = array_merge($vars, $varsOverride);

    return array(
        'files' => $scssFiles,
        'vars'  => $vars,
    );
}

function ope_pro_process_scss_entry_array($entryData)
{
    $scssStart = "";
    $vars      = isset($entryData['vars']) ? $entryData['vars'] : array();
    $scssFiles = isset($entryData['files']) ? $entryData['files'] : array();

    foreach ($vars as $var => $value) {
        $scssStart .= "\${$var} : {$value};\n";
    }

    foreach ($scssFiles as $file) {
        $scssStart .= "@import \"{$file}.scss\";\n";
    }

    return $scssStart;
}

function ope_pro_get_scss_entry($varsOverride = array())
{
    $scssStart = "";

    $entryData = ope_pro_get_scss_entry_array($varsOverride);
    $scssStart = ope_pro_process_scss_entry_array($entryData);

    return $scssStart;
}


function ope_scss_compile($scssStart, $getSerializedObject = false)
{

    $root  = get_stylesheet_directory() . "/assets/scss";
    $roots = apply_filters('ope_pro_scss_roots', array($root));

    if (one_page_express_unsuported_php_version()) {
        return "/* old php version */ ";
    }

    $scss = new Leafo\ScssPhp\Compiler();
    $scss->setImportPaths($roots);

    $content = "";

    $minified  = ! (defined('WP_DEBUG') && WP_DEBUG);
    $formatter = $minified ? "Leafo\ScssPhp\Formatter\Expanded" : "Leafo\ScssPhp\Formatter\Compressed";

    if ($minified) {
        $formatter = "Leafo\ScssPhp\Formatter\Compressed";
    } else {

        $scss->setLineNumberStyle(Leafo\ScssPhp\Compiler::LINE_COMMENTS);

    }

    $scss->setFormatter($formatter);

    try {

        $content = $scss->compile($scssStart);

    } catch (Exception $e) {

        $errorMessage = $e->getMessage();
        $content      = "/* ERROR IN SCSS COMPILATION: {$errorMessage} */ ";

    }

    if ( ! $minified) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $content = "/***\n\n{$scssStart}\n\n***/\n\n$content";
        }
    }

    if ($getSerializedObject) {
        return array(
            'content'    => $content,
            'serialized' => serialize($scss),
        );
    }

    return $content;
}


function ope_pro_get_compiled_css_text()
{
    $scssStart = ope_pro_get_scss_entry();
    $cachedStyle = get_option('one_page_express_cached_compiled_scss', array());

    $hash           = md5($scssStart) . "-" . ope_get_pro_version();
    $hasCachedStyle = (isset($cachedStyle['hash']) && $cachedStyle['hash'] === $hash);
    $isDebug        = (defined('WP_DEBUG') && WP_DEBUG);

    $value = "";



    if ($hasCachedStyle && ! $isDebug) {
        $value = $cachedStyle['value'];
        $value = "/* CACHED SCSS */\n\n{$value}";

    } else {

        $value = ope_scss_compile($scssStart, true);

        if ($isDebug) {

            update_option('one_page_express_cached_compiled_scss', array());

        } else {

            update_option('one_page_express_cached_compiled_scss', array(
                'hash'       => $hash,
                'value'      => $value['content'],
                'serialized' => $value['serialized'],
            ));
        }

        $value = $value['content'];
    }

    return $value;
}

function ope_pro_get_compiled_style_preview()
{

    header('Content-Type: text/css');

    $data = array();

    if (isset($_REQUEST['data'])) {
        $data = $_REQUEST['data'];
    } else {
        $data = ope_pro_get_scss_entry_array();
    }

    $cachedStyle        = get_option('one_page_express_cached_compiled_scss', array());
    $serializedCompiler = isset($cachedStyle['serialized']) ? $cachedStyle['serialized'] : false;

    $scssStart = ope_pro_process_scss_entry_array($data);

    if ($serializedCompiler) {
        $compiler = unserialize($serializedCompiler);
        die("/* unserialized data */\n\n" . $compiler->compile($scssStart));
    }


    $content = ope_scss_compile($scssStart);
    die($content);
}


function ope_pro_compiled_style_inline_output($content)
{
    add_action('wp_head', function () use ($content) {
        ?>
        <style id="ope-compiled-css">
            <?php echo $content; ?>
        </style>
        <?php
    }, PHP_INT_MAX);
}

function ope_pro_compiled_style_link_output($styleURL)
{
    add_action('wp_enqueue_scripts', function () use ($styleURL) {
        $deps = apply_filters('ope_compiled_scss_deps', array('one-page-express-pro-style'));
        wp_enqueue_style('ope-compiled-styles', $styleURL, $deps, ope_get_pro_version());
    }, PHP_INT_MAX);
}


add_action('wp_head', function () {


    if (is_customize_preview()) {
        $content = ope_pro_get_compiled_css_text();
        ope_pro_compiled_style_inline_output($content);

        return;
    }


    // server as css file not cached ( slow loading of css file - requires OPE_PRO_SCSS_AS_FILE defined - for debugging purposes);
    if (defined('OPE_PRO_SCSS_AS_FILE') && OPE_PRO_SCSS_AS_FILE) {
        $ope_compiled_style_url = add_query_arg('action', 'compiled_style_preview', admin_url('/admin-ajax.php'));
        ope_pro_compiled_style_link_output($ope_compiled_style_url);

    } else {
        // css embedded in page ( fast but hackish )
        $content = ope_pro_get_compiled_css_text();
        ope_pro_compiled_style_inline_output($content);
    }


}, 0);


add_filter('cloudpress\customizer\preview_data', function ($data) {
    $data['scss'] = ope_pro_get_scss_entry_array();

    return $data;
});


add_filter('cloudpress\customizer\global_data', function ($data) {

    $settings = array(
        'one_page_express_color_pallete',
        'general_site_typography',
        'general_site_typography_size',
    );

    for ($i = 1; $i <= 6; $i++) {
        $settings[] = "general_site_h{$i}_typography";
    }

    foreach (Kirki::$fields as $id => $field) {
        $choices = isset($field['choices']) ? $field['choices'] : array();
        if (isset($choices['scss_var']) && $choices['scss_var']) {
            $settings[] = $id;
        }
    }

    $settings = apply_filters('ope_scss_settings', $settings);

    if (empty($settings)) {
        $settings = null;
    }

    $data['scss_settings'] = $settings;

    return $data;
});
