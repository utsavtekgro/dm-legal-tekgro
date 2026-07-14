/**
 * Accessible mobile navigation toggle.
 *
 * Dependency-free, deferred. Manages aria-expanded, the .is-open class, and
 * closes the menu on Escape or outside click. No layout is read/written in a
 * loop, so it never causes forced reflow.
 *
 * @package DM_Legal
 */
( function () {
	'use strict';

	var nav = document.getElementById( 'site-navigation' );

	if ( ! nav ) {
		return;
	}

	var toggle = nav.querySelector( '.site-nav__toggle' );
	var menu = nav.querySelector( '#primary-menu' );

	if ( ! toggle || ! menu ) {
		return;
	}

	/**
	 * Set the open/closed state.
	 *
	 * @param {boolean} open Whether the menu should be open.
	 */
	function setState( open ) {
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		nav.classList.toggle( 'is-open', open );
	}

	toggle.addEventListener( 'click', function () {
		var isOpen = 'true' === toggle.getAttribute( 'aria-expanded' );
		setState( ! isOpen );
	} );

	// Close on Escape and return focus to the toggle.
	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && 'true' === toggle.getAttribute( 'aria-expanded' ) ) {
			setState( false );
			toggle.focus();
		}
	} );

	// Close when focus or a click leaves the nav.
	document.addEventListener( 'click', function ( event ) {
		if ( 'true' === toggle.getAttribute( 'aria-expanded' ) && ! nav.contains( event.target ) ) {
			setState( false );
		}
	} );
}() );
