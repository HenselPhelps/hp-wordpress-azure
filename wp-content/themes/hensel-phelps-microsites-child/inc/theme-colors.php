<?php


function ope_theme_print_colors()
{
    $sels        = array();
    $list_colors = array(
        ".team-colors-membercol.item-color .team-colors-icon:hover" => array(
            "properties" => array("color"),
        ),

        ".team-large-square-membercol.item-color h3.team-large-square-membername" => array(
            "properties" => array("color"),
        ),


        ".team-large-square-membercol.item-color .team-large-square-membercard" => array(
            "properties" => array("border-bottom-color"),
        ),

        ".team-colors-membercol.item-color .team-colors-background",


        ".team-small-membercol.item-color img.team-small-memberimg-normal" => array(
            "properties" => array("border-color"),
        ),

        ".features-large-icons-featcol.item-color .features-icon-container",
        ".features-large-icons-featcol.item-color .features-icon-container-nomargin",

        ".features-coloured-icon-boxes-featurecol.item-color a.features-coloured-button",
        ".features-coloured-icon-boxes-featurecol.item-color a.features-coloured-button:hover",
        ".features-coloured-icon-boxes-featurecol.item-color a.features-coloured-button:active",
        ".features-coloured-icon-boxes-featurecol.item-color .features-coloured-icon-boxes-iconcontainer",

        // compatibility
        ".item-color .button.blue, .item-color .button.blue:hover, .item-color .button.blue:active",
        ".item-color .button.green, .item-color .button.green:hover, .item-color .button.green:active",
        ".item-color .button.yellow, .item-color .button.yellow:hover, .item-color .button.yellow:active",
        ".item-color .button.purple, .item-color .button.purple:hover, .item-color .button.purple:active",


        "[data-id] .item-color .bg-alt-color",

        "[data-id] .border-bottom-alt-color.item-color" => array(
            "properties" => array("border-bottom-color"),
        ),

    );

    $colors_selectors = array(
        "color1" => array(

            ".team-colors-membercol:nth-of-type(4n+1) .team-colors-icon:hover"    => array("color"),
            "h3.team-large-square-membername, .fa.font-icon-post, .post-header a" => array("color"),
            ".team-colors-membercol:nth-of-type(4n+1) .team-colors-background",

            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+1)  a.features-coloured-button",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+1)  a.features-coloured-button:hover, .features-coloured-icon-boxes-featurecol:nth-of-type(4n+1)  a.features-coloured-button:active",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+1) .features-coloured-icon-boxes-iconcontainer",

            "img.team-small-memberimg-normal" => array("border-color"),
            ".team-large-square-membercard"   => array("border-bottom-color"),

            ".cp12cols .bg-alt-color, .cp6cols:nth-of-type(2n+1) .bg-alt-color, .cp4cols:nth-of-type(3n+1) .bg-alt-color, .cp3cols:nth-of-type(4n+1) .bg-alt-color, .cp2cols:nth-of-type(6n+1) .bg-alt-color",

            ".cp12cols.border-bottom-alt-color, .cp6cols:nth-of-type(2n+1).border-bottom-alt-color, .cp4cols:nth-of-type(3n+1).border-bottom-alt-color, .cp3cols:nth-of-type(4n+1).border-bottom-alt-color, .cp2cols:nth-of-type(6n+1).border-bottom-alt-color" => array("border-bottom-color"),

            ".features-large-icons-featcol .features-icon-container",
            ".features-icon-container-nomargin",


            'form[type="submit"]',
            '.wpcf7-form [type="submit"]',
            //"a"                                                                                                                                                                                                                                                 => array("color"),
            ".fa.font-icon-23"                                                                                                                                                                                                                                  => array("color"),
            //".fa.font-icon-22"                                                                                                                                                                                                                                  => array("color"),
            ".fa.font-icon-21"                                                                                                                                                                                                                                  => array("color"),
            ".fa.font-video-icon:hover, .fa.font-icon-video-on-bottom:hover"                                                                                                                                                                                    => array("color"),
            "#searchsubmit"                                                                                                                                                                                                                                     => array("background-color", "border-color"),
            ".widget > .widgettitle"                                                                                                                                                                                                                            => array("border-left-color"),
            ".button.blue",
            ".button.blue:hover",
            ".button.blue:active",

            ".post-content" => array("border-bottom-color"),

        ),
        "color2" => array(

            ".team-colors-membercol:nth-of-type(4n+2) .team-colors-icon:hover" => array("color"),
            ".team-colors-membercol:nth-of-type(4n+2) .team-colors-background",
            ".cp12cols .bg-alt-color, .cp6cols:nth-of-type(2n+2) .bg-alt-color, .cp4cols:nth-of-type(3n+2) .bg-alt-color, .cp3cols:nth-of-type(4n+2) .bg-alt-color, .cp2cols:nth-of-type(6n+2) .bg-alt-color",

            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+2)  a.features-coloured-button",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+2)  a.features-coloured-button:hover, .features-coloured-icon-boxes-featurecol:nth-of-type(4n+2)  a.features-coloured-button:active",

            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+2) .features-coloured-icon-boxes-iconcontainer",

            ".cp6cols:nth-of-type(2n+2).border-bottom-alt-color, .cp4cols:nth-of-type(3n+2).border-bottom-alt-color, .cp3cols:nth-of-type(4n+2).border-bottom-alt-color, .cp2cols:nth-of-type(6n+2).border-bottom-alt-color" => array("border-bottom-color"),

            ".button.green",
            ".button.green:hover",
            ".button.green:active",
        ),

        "color3" => array(
            ".team-colors-membercol:nth-of-type(4n+3) .team-colors-icon:hover" => array("color"),
            ".cp4cols:nth-of-type(3n+3) .bg-alt-color, .cp3cols:nth-of-type(4n+3) .bg-alt-color, .cp2cols:nth-of-type(6n+3) .bg-alt-color",
            ".team-colors-membercol:nth-of-type(4n+3) .team-colors-background",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+3)  a.features-coloured-button",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+3)  a.features-coloured-button:hover, .features-coloured-icon-boxes-featurecol:nth-of-type(4n+3)  a.features-coloured-button:active",

            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+3) .features-coloured-icon-boxes-iconcontainer",

            ".cp4cols:nth-of-type(3n+3).border-bottom-alt-color, .cp3cols:nth-of-type(4n+3).border-bottom-alt-color, .cp2cols:nth-of-type(6n+3).border-bottom-alt-color" => array("border-bottom-color"),

            ".button.yellow",
            ".button.yellow:hover",
            ".button.yellow:active",

        ),

        "color4" => array(
            ".team-colors-membercol:nth-of-type(4n+4) .team-colors-icon:hover" => array("color"),
            ".cp12cols .bg-alt-color, .cp6cols:nth-of-type(2n+4) .bg-alt-color, .cp4cols:nth-of-type(3n+4) .bg-alt-color, .cp3cols:nth-of-type(4n+4) .bg-alt-color, .cp2cols:nth-of-type(6n+4) .bg-alt-color",
            ".team-colors-membercol:nth-of-type(4n+4) .team-colors-background",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+4)  a.features-coloured-button",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+4)  a.features-coloured-button:hover, .features-coloured-icon-boxes-featurecol:nth-of-type(4n+4)  a.features-coloured-button:active",
            ".features-coloured-icon-boxes-featurecol:nth-of-type(4n+4) .features-coloured-icon-boxes-iconcontainer",

            ".button.purple",
            ".button.purple:hover",
            ".button.purple:active",

        ),
    );

    $colors_array = get_theme_mod('one_page_express_color_pallete',
        array(
            array("name" => "color1", "value" => "#03a9f4"),
            array("name" => "color2", "value" => "#4caf50"),
            array("name" => "color3", "value" => "#fbc02d"),
            array("name" => "color4", "value" => "#8c239f"),
            array("name" => "color5", "value" => "#ff8c00"),
        )
    );

    $colors = array();

    for ($i = 0; $i < count($colors_array); $i++) {
        $colors[$colors_array[$i]['name']] = $colors_array[$i]['value'];
    }

    foreach ($colors as $color => $value) {
        $darkcol  = ope_darker_color($value);
        $lightcol = ope_lighten_color($value);
        
        $whitetext = Kirki_Color::brightness_difference($value, "#ffffff") >= 50;
        
        array_push($sels, ".button." . $color . "{background-color:" . $value . " !important;}");

        if ($whitetext) {
            array_push($sels, ".button." . $color . "{color:#ffffff;}");
        }

        array_push($sels, ".button." . $color . ":hover{background-color:" . $darkcol . " !important;}");

        array_push($sels, ".fa." . $color . "{color:" . $value . "  !important;}");
        array_push($sels, ".fa." . $color . ":hover{color:" . $darkcol . "  !important;}");


        array_push($sels, "body .header-top .fm2_drop_mainmenu .menu-item.{$color} > a {color:{$value} !important; border-bottom-color:{$value} !important; }");
        array_push($sels, "body .header-top .fm2_drop_mainmenu .menu-item.{$color}:hover > a,body .header-top .fm2_drop_mainmenu .menu-item.{$color}.current-menu-item > a{color:{$lightcol} !important; text-shadow: 0px 0px 0px {$lightcol} !important;}");
    }

    foreach ($colors_selectors as $color => $color_sels) {
        $col     = $colors[$color];
        $darkcol = ope_darker_color($col);
        foreach ($color_sels as $sel => $props) {
            if ( ! $props || ! is_array($props)) {
                $sel   = $color_sels[$sel];
                $props = array("background-color");
            }
            for ($i = 0; $i < count($props); $i++) {
                $prop = $props[$i];
                if (strpos($sel, ":hover") !== false || strpos($sel, ".active") !== false) {
                    array_push($sels, $sel . "{" . $prop . ":" . $darkcol . ";}");
                } else {
                    array_push($sels, $sel . "{" . $prop . ":" . $col . ";}");
                }
            }
        }
    }

    $color1_opacity = Kirki_Color::get_rgba($colors["color1"], 0.75);

    array_push($sels, '#ContentSwap103 .swap-inner, #ContentSwap102 .swap-inner {background-color:' . $color1_opacity . ';}');

    foreach ($list_colors as $selector => $obj) {
        if ( ! $obj || ! is_array($obj)) {
            $obj      = array("properties" => array("background-color"));
            $selector = $list_colors[$selector];
        }

        $prop = $obj["properties"][0];

        foreach ($colors as $color => $value) {
            $sel = str_replace(".item-color", "." . $color, $selector);
            array_push($sels, $sel . "{" . $prop . ":" . $value . ";}");
        }
    }

    foreach ($colors as $color => $value) {
        $color_opacity = Kirki_Color::get_rgba($value, 0.75);
        array_push($sels, ".team-large-square-membercol.$color #ContentSwap103 .swap-inner, .team-large-square-membercol.$color #ContentSwap102 .swap-inner {background-color:$color_opacity;}");
    }


    ?>
    <style type="text/css">
        <?php echo implode("\r\n", $sels); ?>
    </style>
    <?php
}


function one_page_express_get_colors($name = false)
{
    $colors_array = get_theme_mod('one_page_express_color_pallete',
        array(
            array("name" => "color1", "value" => "#03a9f4"),
            array("name" => "color2", "value" => "#4caf50"),
            array("name" => "color3", "value" => "#fbc02d"),
            array("name" => "color4", "value" => "#8c239f"),
            array("name" => "color5", "value" => "#ff8c00"),
        )
    );

    $colors = array();

    foreach ($colors_array as $color) {
        $colors[$color['name']] = $color['value'];
    }

    if ($name && isset($colors[$name])) {
        return $colors[$name];
    }

    return $colors;
}


function ope_pro_vars_typography()
{
    $typography = array();

    $data              = Kirki::get_option('one_page_express', 'general_site_typography');
    $generalSize       = Kirki::get_option('one_page_express', 'general_site_typography_size');
    $data['font-size'] = $generalSize . "px";

    foreach ($data as $key => $value) {
        $key                       = str_replace('-', '_', $key);
        $typography["typo_{$key}"] = $value;
    }

    for ($i = 1; $i <= 6; $i++) {
        $data = Kirki::get_option('one_page_express', "general_site_h{$i}_typography");
        foreach ($data as $key => $value) {
            $key                             = str_replace('-', '_', $key);
            $typography["typo_h{$i}_{$key}"] = $value;
        }
    }

    return $typography;
}
