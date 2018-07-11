<?php

namespace OnePageExpress;


class SidebarGroupButtonControl extends \Kirki_Customize_Control
{

    public $type = "sidebar-button-group";
    public $popupId = '';

    public function __construct($manager, $id,  $args = array())
    {
        $this->popupId = uniqid('cp-sidebar-button-group-');
        parent::__construct($manager, $id, $args);
    }

    public function enqueue()
    {
        $jsRoot = get_stylesheet_directory_uri() . "/customizer/assets/js";
        wp_enqueue_script('sb-group-button-control', $jsRoot . "/sb-group-button-control.js");

    }

    public function json()
    {
        $json =  parent::json();
        $json['popup'] = $this->popupId;

        return $json;
    }

    protected function content_template()
    {
        ?>

        <label>

            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>

                    <button type="button" class="button" data-sidebar-container="{{ data.popup }}" id="group_customize-button-{{ data.popup }}">
                        {{{ data.label }}}
                    </button>
        </label>

        <div id="{{ data.popup }}-popup" class="reiki-right-section">
            <span data-reiki-close-right="true" title="Close Panel" class="close-panel"></span>
            <ul class="section-settings-container accordion-section-content no-border"></ul>
        </div>
        <?php

    }
}
