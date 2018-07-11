wp.customize.controlConstructor['web-gradients'] = wp.customize.Control.extend({

	ready: function () {

		'use strict';

		var control = this;

		// wp.media.cp.extendFrameWithWebGradients
		// Change the value
		this.container.on('click', 'button, .webgradient-icon-preview .webgradient', function () {

			top.CP_Customizer.openMediaCustomFrame(
				wp.media.cp.extendFrameWithWebGradients,
				"cp_web_gradients",
				"Select Gradient",
				true,
				function (attachement) {
					// console.log(attachement);

					if(attachement && attachement[0]){
						 control.setting.set(attachement[0].gradient );
						 control.container.find('.webgradient-icon-preview > div.webgradient').attr('class','webgradient ' + attachement[0].gradient );
					}
				}
			)
		});

	}

});
