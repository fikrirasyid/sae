// This script is loaded both on the frontend page and in the Visual Builder.

(function($) {
	// Detect if current screen is retina display or not
	var isRetinaDisplay = window.matchMedia('only screen and (min-resolution: 192dpi)').matches;

	$(document).ready(function() {
		// Loop all sae placeholder image
		$('.sae-image--placeholder').each(function() {
			var $placeholder = $(this);
			var imageWidth = $placeholder.parent().width() * (isRetinaDisplay ? 2 : 1);

			// get all available image sizes
			var availableSizes = $placeholder.attr('data-sae-image-width').split(',').map(function(size) {
				return parseInt(size)
			});

			// Get closest size for current image width
			var closestSize = availableSizes.filter(function(size) {
				return size >= imageWidth;
			}).sort(function(a, b) {
				return a - b;
			})[0];

			if (closestSize) {
				var $imageWrapper = $placeholder.parent();

				// Load actual image then append it to image wrapper
				var image = new Image();

				image.src = $placeholder.attr('data-sae-src-width-' + closestSize);
				image.className = 'sae-image--progressive';
				image.onload = function() {
					$imageWrapper.addClass('sae-actual-image-loaded');

					// Avoid duplication
					$imageWrapper.find('.sae-image--progressive').remove();

					$imageWrapper.append($(this));
				}
			}
		});
	});
})(jQuery);
