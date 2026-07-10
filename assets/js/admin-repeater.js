/**
 * Vanilla-JS add/remove-row behavior for the native repeater meta boxes
 * (see inc/meta-box-repeater.php). No build step, no dependency beyond the
 * jQuery that wp-admin already loads (used only for the wp.media modal).
 */
( function () {
	'use strict';

	var rowCounter = 0;

	function nextIndex() {
		rowCounter += 1;
		return 'new' + Date.now() + rowCounter;
	}

	function addRow( repeater ) {
		var template = repeater.querySelector( '[data-repeater-template]' );
		var rowsWrap = repeater.querySelector( '[data-repeater-rows]' );
		if ( ! template || ! rowsWrap ) {
			return;
		}

		var html = template.innerHTML.split( '__INDEX__' ).join( nextIndex() );
		var wrapper = document.createElement( 'div' );
		wrapper.innerHTML = html.trim();
		var newRow = wrapper.firstElementChild;
		if ( newRow ) {
			rowsWrap.appendChild( newRow );
		}
	}

	function removeRow( button ) {
		var row = button.closest( '[data-repeater-row]' );
		if ( row ) {
			row.parentNode.removeChild( row );
		}
	}

	function openMediaPicker( button ) {
		if ( typeof wp === 'undefined' || ! wp.media ) {
			return;
		}

		var row       = button.closest( '[data-repeater-row]' );
		var idInput   = row.querySelector( '.dmlegal-repeater__media-id' );
		var preview   = row.querySelector( '.dmlegal-repeater__media-preview' );

		var frame = wp.media( {
			title: 'Select Icon',
			multiple: false,
			library: { type: 'image' },
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			idInput.value = attachment.id;

			var thumbUrl = ( attachment.sizes && attachment.sizes.thumbnail )
				? attachment.sizes.thumbnail.url
				: attachment.url;

			preview.innerHTML = '<img src="' + thumbUrl + '" width="60" height="60" alt="">';
		} );

		frame.open();
	}

	function clearMedia( button ) {
		var row     = button.closest( '[data-repeater-row]' );
		var idInput = row.querySelector( '.dmlegal-repeater__media-id' );
		var preview = row.querySelector( '.dmlegal-repeater__media-preview' );

		idInput.value = '';
		preview.innerHTML = '';
	}

	document.addEventListener( 'click', function ( event ) {
		var addBtn = event.target.closest( '.dmlegal-repeater__add' );
		if ( addBtn ) {
			event.preventDefault();
			addRow( addBtn.closest( '[data-repeater]' ) );
			return;
		}

		var removeBtn = event.target.closest( '.dmlegal-repeater__remove' );
		if ( removeBtn ) {
			event.preventDefault();
			removeRow( removeBtn );
			return;
		}

		var selectBtn = event.target.closest( '.dmlegal-repeater__media-select' );
		if ( selectBtn ) {
			event.preventDefault();
			openMediaPicker( selectBtn );
			return;
		}

		var clearBtn = event.target.closest( '.dmlegal-repeater__media-clear' );
		if ( clearBtn ) {
			event.preventDefault();
			clearMedia( clearBtn );
		}
	} );
} )();
