/**
 * Net Neutrality JS
 */

( function( $ ) {
	function netneutrality () {
		var nnLoading,
			posts = $( 'body.blog .post' ),
			randomElements = posts.get().sort( function() {
				return Math.round( Math.random() ) - 0.5;
			} ).slice( 0, 99 ),
			decodedLoading = $( '<div/>' ).html( netNeutrality.strings.loading ).text();

		var bgColor = $( '.post' ).css( 'background-color' );
		if ( bgColor.split( 'rgba' ).length > 1 ) {
			bgColor = '#fff';
		}

		nnLoading = $( randomElements );
		nnLoading.addClass( 'nn-loading' );
		nnLoading.append( '<div style="background-color: ' + bgColor + ';" class="nn-overlay"><div class="nn-text">' + decodedLoading + '<div><div>' );


		setTimeout( function() {
			$( '.nn-text' ).html( netNeutrality.strings.stillLoading );
		}, 4000 );

		setTimeout( function() {
			var decoded = $( '<div/>' ).html( netNeutrality.strings.yepStillLoading ).text();
			$( '.nn-text' ).html( decoded );
		}, 8000 );

		setTimeout( function() {
			var decoded = $( '<div/>' ).html( netNeutrality.strings.willHappen ).text();
			$( '.nn-text' ).html( decoded );
		}, 12000 );

		nnLoading.on( 'click', '.nn-overlay', function () {
			var thisOverlay = $ ( this );
			nnOverlay = $( '#net-neutrality-overlay' );
			nnOverlay.show().css( 'opacity', '1' )
			$( '#net-neutrality-overlay-action' ).focus();

			$( '#net-neutality-overlay-content' ).click( function( event ) {
				event.stopPropagation();
			} );

			nnOverlay.on( 'click', function() {
				$( '.post' ).removeClass( 'nn-loading' );
				thisOverlay.remove();
				$( this ).hide().css( 'opacity', '0' );
				$( '#net-neutrality-ribbon' ).show().css( 'opacity', '1' );
			} );

			$( '#net-neutrality-overlay-close' ).on( 'click', function() {
				event.preventDefault();
				$( '.post' ).removeClass( 'nn-loading' );
				thisOverlay.remove();
				nnOverlay.hide().css( 'opacity', '0' );
				$( '#net-neutrality-ribbon' ).show().css( 'opacity', '1' );
			} );
		} );
	}

	netneutrality();
})( jQuery );
