(function( $ ) {
	'use strict';

	$(function () {
		var dropdown = document.getElementById(Main_Categories_Widget.dropdown_id);
		if (dropdown !== null) {
			function onCatChange() {
				if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
					dropdown.parentNode.submit();
				}
			}
			dropdown.onchange = onCatChange;
		}
	});

})( jQuery );
