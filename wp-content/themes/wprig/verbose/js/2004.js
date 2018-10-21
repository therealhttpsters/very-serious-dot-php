"use strict";

$(function () {
	$("#draggable").draggable();
});
$(document).click(function () {
	$(".site-description").effect("shake");
});
$(document).ready(function () {

	$(function () {
		var progressbar = $("#progressbar"),
		    progressLabel = $(".progress-label");

		progressbar.progressbar({
			value: false,
			change: function change() {
				progressLabel.text(progressbar.progressbar("value") + "%");
			},
			complete: function complete() {
				progressLabel.text("Complete!");
			}
		});

		function progress() {
			var val = progressbar.progressbar("value") || 0;

			progressbar.progressbar("value", val + 2);

			if (val < 99) {
				setTimeout(progress, 80);
			}
			if (val == 100) {
				$('#progressbar').delay(300).fadeOut();
				$('#page').delay(800).fadeIn(700);
			}
		}

		setTimeout(progress, Math.random() * 2700);
	});
});