jQuery(function ($) {
	$("#afilnet_login_button").live("click", function () {
		var user = $("#afilnet_settings_username").val();
		var pass = $("#afilnet_settings_password").val();
		var data = {
			action: 'afilnet_test_login',
			user: user,
			pass: pass
		};
		$.post(ajaxurl, data, function (response) {
			response = JSON.parse(response);
			var element = $("#apartadoCredenciales");
			if (typeof (response.status) !== 'undefined') {
				if (response.status == "SUCCESS") {
					element.css("background-color", "rgba(0, 255, 0, 0.3)");
					element.html('<span class="dashicons dashicons-yes"></span>' + response.result + " credits");
				} else {
					element.css("background-color", "rgba(255, 0, 0, 0.3)");
					element.html('<span class="dashicons dashicons-no"></span>'+response.error);
				}
			} else {
				element.css("background-color", "rgba(255, 0, 0, 0.3)");
				element.html('<span class="dashicons dashicons-no"></span>'+response.error);
			}
		});
	});
	$( "#afilnet-accordion" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
});

