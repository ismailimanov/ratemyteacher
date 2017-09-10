(function() {

	var bodyEl = document.body,
		indhold = document.querySelector( '.indhold' ),
		aabnKnap = document.getElementById( 'aabnMenu' ),
		lukKnap = document.getElementById( 'lukMenu' ),
		erAabn = false;

	function init() {
		initEvents();
	}

	function initEvents() {
		aabnKnap.addEventListener( 'click', menuSkift );
		if( lukKnap ) {
			lukKnap.addEventListener( 'click', menuSkift );
		}

		indhold.addEventListener( 'click', function(ev) {
			var target = ev.target;
			if( erAabn && target !== aabnKnap ) {
				menuSkift();
			}
		} );
	}

	function menuSkift() {
		if( erAabn ) {
			classie.remove( bodyEl, 'visMenu' );
		}
		else {
			classie.add( bodyEl, 'visMenu' );
		}
		erAabn = !erAabn;
	}

	init();

})();