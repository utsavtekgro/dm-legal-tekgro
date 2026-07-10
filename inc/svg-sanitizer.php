<?php
/**
 * Safe SVG upload support.
 *
 * WordPress excludes SVG from allowed upload mime types by default because
 * an unsanitized SVG can carry <script>, event-handler attributes, or
 * external references and behave like an XSS payload when opened directly.
 * This file re-enables SVG uploads for users who can already upload files,
 * but every SVG is rewritten through a strict allow-list sanitizer before
 * it is ever saved to disk. Nothing here trusts the uploading user, only
 * the sanitizer's output.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow the svg extension/mime for anyone who already has the upload_files
 * capability (WP's normal gate for the media library).
 */
function dmlegal_allow_svg_upload( array $mimes ): array {
	if ( current_user_can( 'upload_files' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'dmlegal_allow_svg_upload' );

/**
 * PHP's fileinfo extension frequently misreports SVG (text/plain,
 * text/html, or text/xml) depending on the system's libmagic version,
 * which makes core's real-mime check reject valid SVGs. Recognize SVG by
 * content signature and force the correct type/ext when it matches.
 */
function dmlegal_fix_svg_filetype( array $data, string $file, string $filename ): array {
	if ( ! preg_match( '/\.svg$/i', $filename ) ) {
		return $data;
	}

	$contents = file_get_contents( $file, false, null, 0, 4096 );
	if ( $contents !== false && preg_match( '/<svg[\s>]/i', $contents ) ) {
		$data['ext']             = 'svg';
		$data['type']            = 'image/svg+xml';
		$data['proper_filename'] = $filename;
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'dmlegal_fix_svg_filetype', 10, 3 );

/**
 * Sanitize the uploaded file's contents in place before WordPress moves it
 * into the uploads directory. Runs on every upload; non-SVG files pass
 * through untouched.
 */
function dmlegal_sanitize_svg_prefilter( array $file ): array {
	if ( ( $file['type'] ?? '' ) !== 'image/svg+xml' || empty( $file['tmp_name'] ) ) {
		return $file;
	}

	$raw = file_get_contents( $file['tmp_name'] );
	if ( $raw === false ) {
		$file['error'] = __( 'Could not read the uploaded SVG file.', 'dmlegal' );
		return $file;
	}

	$clean = dmlegal_sanitize_svg_markup( $raw );
	if ( $clean === null ) {
		$file['error'] = __( 'This SVG could not be verified as safe and was rejected.', 'dmlegal' );
		return $file;
	}

	file_put_contents( $file['tmp_name'], $clean );

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'dmlegal_sanitize_svg_prefilter' );

/**
 * Strip an SVG document down to a safe allow-listed subset of elements and
 * attributes. Returns null if the input isn't parseable as SVG at all.
 */
function dmlegal_sanitize_svg_markup( string $raw ): ?string {
	$allowed_tags = [
		'svg', 'g', 'path', 'circle', 'rect', 'line', 'polyline', 'polygon',
		'ellipse', 'defs', 'clippath', 'lineargradient', 'radialgradient',
		'stop', 'title', 'desc', 'use', 'symbol', 'mask',
	];

	$allowed_attrs = [
		'id', 'class', 'viewbox', 'width', 'height', 'fill', 'fill-rule',
		'fill-opacity', 'stroke', 'stroke-width', 'stroke-linecap',
		'stroke-linejoin', 'stroke-opacity', 'stroke-dasharray', 'opacity',
		'd', 'cx', 'cy', 'r', 'rx', 'ry', 'x', 'y', 'x1', 'y1', 'x2', 'y2',
		'points', 'transform', 'offset', 'stop-color', 'stop-opacity',
		'gradientunits', 'gradienttransform', 'clip-path', 'mask',
		'xmlns', 'xmlns:xlink', 'xlink:href', 'href', 'version', 'role',
		'aria-hidden', 'preserveaspectratio',
	];

	// Reject outright rather than parse: a DOCTYPE/ENTITY declaration has
	// no legitimate purpose in an icon SVG and is the classic XXE vector.
	if ( preg_match( '/<!\s*(DOCTYPE|ENTITY)/i', $raw ) ) {
		return null;
	}

	$previous_setting = libxml_use_internal_errors( true );
	$dom              = new DOMDocument();
	$loaded           = $dom->loadXML( $raw, LIBXML_NONET );
	libxml_clear_errors();
	libxml_use_internal_errors( $previous_setting );

	if ( ! $loaded || ! $dom->documentElement || strtolower( $dom->documentElement->tagName ) !== 'svg' ) {
		return null;
	}

	$xpath = new DOMXPath( $dom );
	foreach ( $xpath->query( '//*' ) as $node ) {
		/** @var DOMElement $node */
		$tag_name = strtolower( $node->tagName );

		if ( ! in_array( $tag_name, $allowed_tags, true ) ) {
			$node->parentNode->removeChild( $node );
			continue;
		}

		foreach ( iterator_to_array( $node->attributes ) as $attr ) {
			/** @var DOMAttr $attr */
			$attr_name = strtolower( $attr->name );
			$attr_val  = trim( $attr->value );

			$is_event_handler = strpos( $attr_name, 'on' ) === 0;
			$is_script_url     = (bool) preg_match( '/^\s*(javascript|data):/i', $attr_val );
			$is_href_attr      = in_array( $attr_name, [ 'href', 'xlink:href' ], true );
			$is_unsafe_href     = $is_href_attr && strpos( $attr_val, '#' ) !== 0;

			if (
				! in_array( $attr_name, $allowed_attrs, true )
				|| $is_event_handler
				|| $is_script_url
				|| $is_unsafe_href
				|| ( $attr_name === 'style' )
			) {
				$node->removeAttribute( $attr->name );
			}
		}
	}

	// Belt-and-braces: remove any comments/processing instructions that
	// slipped through (e.g. XML declarations pointing at external DTDs).
	foreach ( $xpath->query( '//comment()|//processing-instruction()' ) as $node ) {
		$node->parentNode->removeChild( $node );
	}

	return $dom->saveXML( $dom->documentElement );
}
