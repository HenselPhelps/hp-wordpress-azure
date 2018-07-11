wp.customize.controlConstructor['sidebar-button-group'] = wp.customize.Control.extend({
    ready: function () {
        var control = this;
        var components = this.params.choices;
        var popupId = this.params.popup;

        control.container.find('#group_customize-button-' + popupId).click(function () {
            CP_Customizer.openRightSidebar(popupId);
        });

        control.container.find('#' + popupId + '-popup > ul').on('focus',function(event){
                return false;
        });

        wp.customize.bind('pane-contents-reflowed', function () {
            var holder = control.container.find('#' + popupId + '-popup > ul');
            _.each(components, function (c) {
                var _c = wp.customize.control(c);
                if (_c) {
                    holder.append(_c.container);
                }
            });
        });

        jQuery(function () {


        });
    }
});
