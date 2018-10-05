<?php
/**
 * Class AMP_Gallery_Embed_Handler
 *
 * @package AMP
 */

/**
 * Class AMP_Gallery_Embed_Handler
 *
 * @since 0.2
 */
class AMP_Gallery_Embed_Handler extends AMP_Base_Embed_Handler {

	/**
	 * Register embed.
	 */
	public function register_embed() {
		add_filter( 'post_gallery', array( $this, 'maybe_override_gallery' ), 10, 2 );
	}

	/**
	 * Unregister embed.
	 */
	public function unregister_embed() {}

	/**
	 * Shortcode handler.
	 *
	 * @param array $attr Shortcode attributes.
	 * @return string Rendered gallery.
	 */
	public function shortcode( $attr ) {
		$post = get_post();

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$atts = shortcode_atts( array(
			'order'   => 'ASC',
			'orderby' => 'menu_order ID',
			'id'      => $post ? $post->ID : 0,
			'include' => '',
			'exclude' => '',
			'size'    => array( $this->args['width'], $this->args['height'] ),
			'link'    => 'none',
		), $attr, 'gallery' );

		if ( ! empty( $attr['amp-lightbox'] ) ) {
			$atts['lightbox'] = filter_var( $attr['amp-lightbox'], FILTER_VALIDATE_BOOLEAN );
		}

		$id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$attachments = get_posts( array(
				'include'        => $atts['include'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
				'fields'         => 'ids',
			) );
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array(
				'post_parent'    => $id,
				'exclude'        => $atts['exclude'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
				'fields'         => 'ids',
			) );
		} else {
			$attachments = get_children( array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
				'fields'         => 'ids',
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		$urls = array();
		foreach ( $attachments as $attachment_id ) {
			list( $url, $width, $height ) = wp_get_attachment_image_src( $attachment_id, $atts['size'], true );

			if ( ! $url ) {
				continue;
			}

			$href = null;
			if ( empty( $atts['lightbox'] ) ) {
				if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
					$href = $url;
				} elseif ( ! empty( $atts['link'] ) && 'post' === $atts['link'] ) {
					$href = get_attachment_link( $attachment_id );
				}
			}

			$urls[] = array(
				'href'   => $href,
				'url'    => $url,
				'width'  => $width,
				'height' => $height,
			);
		}

		$args = array(
			'images' => $urls,
		);
		if ( ! empty( $atts['lightbox'] ) ) {
			$args['lightbox'] = true;
			$lightbox_tag     = AMP_HTML_Utils::build_tag(
				'amp-image-lightbox',
				array(
					'id'                           => AMP_Base_Sanitizer::AMP_IMAGE_LIGHTBOX_ID,
					'layout'                       => 'nodisplay',
					'data-close-button-aria-label' => __( 'Close', 'amp' ),
				)
			);
			/* We need to add lightbox tag, too. @todo Could there be a better alternative for this? */
			return $this->render( $args ) . $lightbox_tag;
		}

		return $this->render( $args );
	}

	/**
	 * Override the output of gallery_shortcode() if amp-carousel is not false.
	 *
	 * The 'Gallery' widget also uses this function.
	 * This ensures that it outputs an <amp-carousel>.
	 *
	 * @param string $html Markup to filter, possibly ''.
	 * @param array  $attributes Shortcode attributes.
	 * @return string $html Markup for the gallery.
	 */
	public function maybe_override_gallery( $html, $attributes ) {
		$is_lightbox = isset( $attributes['amp-lightbox'] ) && true === filter_var( $attributes['amp-lightbox'], FILTER_VALIDATE_BOOLEAN );
		if ( isset( $attributes['amp-carousel'] ) && false === filter_var( $attributes['amp-carousel'], FILTER_VALIDATE_BOOLEAN ) ) {
			if ( true === $is_lightbox ) {
				remove_filter( 'post_gallery', array( $this, 'maybe_override_gallery' ), 10 );
				$attributes['link'] = 'none';
				$html               = '<ul class="amp-lightbox">' . gallery_shortcode( $attributes ) . '</ul>';
				add_filter( 'post_gallery', array( $this, 'maybe_override_gallery' ), 10, 2 );
			}

			return $html;
		}
		return $this->shortcode( $attributes );
	}

	/**
	 * Render.
	 *
	 * @param array $args Args.
	 * @return string Rendered.
	 */
	public function render( $args ) {
		$this->did_convert_elements = true;

		$args = wp_parse_args( $args, array(
			'images' => false,
		) );

		if ( empty( $args['images'] ) ) {
			return '';
		}

		$images = array();
		foreach ( $args['images'] as $props ) {
			$image_atts = array(
				'src'    => $props['url'],
				'width'  => $props['width'],
				'height' => $props['height'],
				'layout' => 'responsive',
			);
			if ( ! empty( $args['lightbox'] ) ) {
				$image_atts['lightbox'] = '';
				$image_atts['on']       = 'tap:' . AMP_Img_Sanitizer::AMP_IMAGE_LIGHTBOX_ID;
				$image_atts['role']     = 'button';
				$image_atts['tabindex'] = 0;
			}
			$image = AMP_HTML_Utils::build_tag(
				'amp-img',
				$image_atts
			);

			if ( ! empty( $props['href'] ) ) {
				$image = AMP_HTML_Utils::build_tag(
					'a',
					array(
						'href' => $props['href'],
					),
					$image
				);
			}

			$images[] = $image;
		}

		return AMP_HTML_Utils::build_tag(
			'amp-carousel',
			array(
				'width'  => $this->args['width'],
				'height' => $this->args['height'],
				'type'   => 'slides',
				'layout' => 'responsive',
			),
			implode( PHP_EOL, $images )
		);
	}
}
