/**
 * Net Neutrality JS
 */

( function( $ ) {
	function netneutrality () {
		var nnLoading,
			posts = $( 'body.blog .post' ),
			randomElements = posts.get().sort( function() {
				return Math.round( Math.random() ) - 0.5;
			} ).slice( 0, 3 );

		var bgColor = $( '.post' ).css( 'background-color' );
		if ( bgColor.split( 'rgba' ).length > 1 ) {
			bgColor = '#fff';
		}

		nnLoading = $( randomElements );
		nnLoading.addClass( 'nn-loading' );
		nnLoading.append( '<div style="background-color: ' + bgColor + ';" class="nn-overlay"><div class="nn-text">Loading...<div><div>' );

		setTimeout(function() {
			$('.nn-text').html('Still loading...');
		}, 4000);

		setTimeout(function() {
			$('.nn-text').html('Yep... <em>still</em> loading...');
		}, 8000);

		setTimeout(function() {
			$('.nn-text').html('This is what will happen without real net neutrality. <br><strong>Make it stop!</strong>');
		}, 12000);

		nnLoading.on( 'click', '.nn-overlay', function () {
			var thisOverlay = $ ( this );
			nnOverlay = $( '#net-neutrality-overlay' );
			nnOverlay.show().css( 'opacity', '1' );

			$( '#net-neutality-overlay-content' ).click( function( event ) {
				event.stopPropagation();
			} );

			nnOverlay.on( 'click', function() {
				var post = thisOverlay.closest( '.post' );
				post.removeClass( 'nn-loading' );
				thisOverlay.remove();
				$( this ).hide().css( 'opacity', '0' );
			} );
		} );
	}

	netneutrality();
})( jQuery );
