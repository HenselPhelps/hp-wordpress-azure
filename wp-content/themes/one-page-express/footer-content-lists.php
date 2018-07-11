<div class="footer">
    <div class="row_201">
        <div class="column_209 gridContainer">
            <div class="row_202">
                <div class="footer-column-colored">
                    <?php one_page_express_logo(true); ?>
                    <p class="dev-team-copy">Developed by: <br/> Hensel Phelps IT Development Team</p>
<div>
                    <a href="https://www.henselphelps.com">
	<img class="footer-hp-logo" src="https://hawaii-state-hospital.azurewebsites.net/wp-content/uploads/2018/05/Plan-Build-Manage-white.png"/>
	</a>
</div>
                    <div class="row_205">
                        <?php one_page_express_footer_social_icons();?>
                    </div>
                    <?php echo one_page_express_copyright(); ?>
                </div>
                <div class="column_210 extended-column">
                    <div>
                        <?php 
              if (!is_active_sidebar('one_page_express_first_box_widgets') && is_customize_preview()) { 
                echo "<div>".__("Go to widgets section to add a widget here.", 'one-page-express')."</div>";
              } else {
                dynamic_sidebar('one_page_express_first_box_widgets'); 
              }
            ?>
                    </div>
                </div>
                <div class="column_210 hide-me">
                    <div>
                        <?php 
              if (!is_active_sidebar('one_page_express_second_box_widgets') && is_customize_preview()) { 
                echo "<div>".__("Go to widgets section to add a widget here.", 'one-page-express')."</div>";
              } else {
                dynamic_sidebar('one_page_express_second_box_widgets'); 
              }
            ?>
                    </div>
                </div>
                <div class="column_210 hide-me">
                    <div>
                        <?php 
              if (!is_active_sidebar('one_page_express_third_box_widgets') && is_customize_preview()) { 
                echo "<div>".__("Go to widgets section to add a widget here.", 'one-page-express')."</div>";
              } else {
                dynamic_sidebar('one_page_express_third_box_widgets'); 
              }
            ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php wp_footer();?>
</body>

</html>
