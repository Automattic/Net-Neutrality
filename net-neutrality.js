/**
 * Net Neutrality JS
 */

function netneutrality () {

	// add loading class to a couple of random posts
	var randomElements = jQuery("body.blog").get().sort(function() {
		return Math.round(Math.random()) - 0.5;
	}).slice(0, 5);

	// add class and text
	jQuery(randomElements).addClass('nn-loading');
	var bgColor = jQuery('body.blog').css('background-color');
	if ( bgColor.split('rgba').length > 1 ) {
		bgColor = '#fff';
	}
	jQuery('.nn-loading').append('<div style="background-color: ' + bgColor + ';" class="nn-overlay"><div class="nn-text">Loading...<div><div>')

	// open popup link
	jQuery('.nn-loading').click(function () {
		jQuery('#net-neutrality-overlay').show().css('opacity', '1');
	});

	// close on anywhere click
	jQuery('#net-neutrality-overlay').click(function () {
		jQuery(this).remove();
		jQuery('.nn-loading').removeClass('nn-loading');
		jQuery('.nn-text').remove();
		jQuery('#net-neutrality-ribbon').show();
		jQuery('#net-neutrality-ribbon').css('opacity', '1');
	});

};

netneutrality();

// change text after a while
jQuery(document).ready(function () {

	setTimeout(function() {
		jQuery('.nn-text').html('Still loading...');
	}, 4000);

	setTimeout(function() {
		jQuery('.nn-text').html('Yep... <em>still</em> loading...');
	}, 8000);

	setTimeout(function() {
		jQuery('.nn-text').html('This is what will happen without real net neutrality. <br><strong>Make it stop!</strong>');
	}, 12000);

});
