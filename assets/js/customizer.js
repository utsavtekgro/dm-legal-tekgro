/**
 * Customizer live preview.
 *
 * Binds site title/description to postMessage transports so edits render
 * instantly without a full refresh.
 *
 * @package DM_Legal
 */
( function ( api ) {
	'use strict';

	api( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			var el = document.querySelector( '.site-branding__title a' );
			if ( el ) {
				el.textContent = to;
			}
		} );
	} );

	api( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			var el = document.querySelector( '.site-branding__desc' );
			if ( el ) {
				el.textContent = to;
			}
		} );
	} );
}( wp.customize ) );
