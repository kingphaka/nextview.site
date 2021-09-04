<?php
namespace AIOSEO\Plugin\Common\Meta;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the (Open Graph) description.
 *
 * @since 4.0.0
 */
class Description {
	/**
	 * Class constructor.
	 *
	* @since 4.1.2
	 */
	public function __construct() {
		$this->helpers = new Helpers( 'description' );
	}

	/**
	 * Returns the homepage description.
	 *
	 * @since 4.0.0
	 *
	 * @return string The homepage description.
	 */
	public function getHomePageDescription() {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$description = $this->getPostDescription( (int) get_option( 'page_on_front' ) );
			return $description ? $description : aioseo()->helpers->decodeHtmlEntities( get_bloginfo( 'description' ) );
		}

		$description = $this->helpers->prepare( aioseo()->options->searchAppearance->global->metaDescription );
		return $description ? $description : aioseo()->helpers->decodeHtmlEntities( get_bloginfo( 'description' ) );
	}

	/**
	 * Returns the description for the current page.
	 *
	 * @since 4.0.0
	 *
	 * @param  WP_Post $post    The post object (optional).
	 * @param  boolean $default Whether we want the default value, not the post one.
	 * @return string           The page description.
	 */
	public function getDescription( $post = null, $default = false ) {
		if ( is_home() && 'posts' === get_option( 'show_on_front' ) ) {
			return $this->getHomePageDescription();
		}

		if ( $post || is_singular() || aioseo()->helpers->isStaticPage() ) {
			$description = $this->getPostDescription( $post, $default );
			if ( $description ) {
				return $description;
			}

			if ( is_attachment() ) {
				$post    = empty( $post ) ? aioseo()->helpers->getPost() : $post;
				$caption = wp_get_attachment_caption( $post->ID );
				return $caption ? $this->helpers->prepare( $caption ) : $this->helpers->prepare( $post->post_content );
			}
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$term = $post ? $post : get_queried_object();
			return $this->getTermDescription( $term, $default );
		}

		if ( is_author() ) {
			$description = $this->helpers->prepare( aioseo()->options->searchAppearance->archives->author->metaDescription );
			if ( $description ) {
				return $description;
			}

			$author = get_queried_object();
			return $author ? $this->helpers->prepare( get_the_author_meta( 'description', $author->ID ) ) : '';
		}

		if ( is_date() ) {
			return $this->helpers->prepare( aioseo()->options->searchAppearance->archives->date->metaDescription );
		}

		if ( is_search() ) {
			return $this->helpers->prepare( aioseo()->options->searchAppearance->archives->search->metaDescription );
		}

		if ( is_archive() ) {
			$postType = get_queried_object();
			$options  = aioseo()->options->noConflict();
			if ( $options->searchAppearance->dynamic->archives->has( $postType->name ) ) {
				return $this->helpers->prepare( aioseo()->options->searchAppearance->dynamic->archives->{ $postType->name }->metaDescription );
			}
		}
	}

	/**
	 * Returns the description for a given post.
	 *
	 * @since 4.0.0
	 *
	 * @param  WP_Post|int $post    The post object or ID.
	 * @param  boolean     $default Whether we want the default value, not the post one.
	 * @return string               The post description.
	 */
	public function getPostDescription( $post, $default = false ) {
		$post = $post && is_object( $post ) ? $post : aioseo()->helpers->getPost( $post );

		static $posts = [];
		if ( isset( $posts[ $post->ID ] ) ) {
			return $posts[ $post->ID ];
		}

		$description = '';
		$metaData    = aioseo()->meta->metaData->getMetaData( $post );
		if ( ! empty( $metaData->description ) && ! $default ) {
			$description = $this->helpers->prepare( $metaData->description, $post->ID, false, false );
		}

		if (
			$description ||
			(
				in_array( 'autogenerateDescriptions', aioseo()->internalOptions->deprecatedOptions, true ) &&
				! aioseo()->options->deprecated->searchAppearance->advanced->autogenerateDescriptions
			)
		) {
			$posts[ $post->ID ] = $description;
			return $description;
		}

		$description = $this->helpers->sanitize( $this->getPostTypeDescription( $post->post_type ), $post->ID, $default );

		$generateDescriptions = apply_filters( 'aioseo_generate_descriptions_from_content', true, [ $post ] );
		if ( ! $description && ! post_password_required( $post ) ) {
			$description = $post->post_excerpt;
			if (
				$generateDescriptions &&
				in_array( 'useContentForAutogeneratedDescriptions', aioseo()->internalOptions->deprecatedOptions, true ) &&
				aioseo()->options->deprecated->searchAppearance->advanced->useContentForAutogeneratedDescriptions
			) {
				$description = aioseo()->helpers->getContent( $post );
			}

			$description = $this->helpers->sanitize( $description, $post->ID, $default );
			if ( ! $description && $generateDescriptions && $post->post_content ) {
				$description = $this->helpers->sanitize( aioseo()->helpers->getContent( $post ), $post->ID, $default, false );
			}
		}

		if ( ! is_paged() ) {
			if ( in_array( 'descriptionFormat', aioseo()->internalOptions->deprecatedOptions, true ) ) {
				$descriptionFormat = aioseo()->options->deprecated->searchAppearance->global->descriptionFormat;
				if ( $descriptionFormat ) {
					$description = preg_replace( '/#description/', $description, $descriptionFormat );
				}
			}
		}

		$posts[ $post->ID ] = $description ? $this->helpers->prepare( $description, $post->ID, $default ) : $this->helpers->prepare( term_description( '' ), $post->ID, $default );
		return $posts[ $post->ID ];
	}

	/**
	 * Retrieve the default description for the post type.
	 *
	 * @since 4.0.6
	 *
	 * @param  string $postType The post type.
	 * @return string           The description.
	 */
	public function getPostTypeDescription( $postType ) {
		static $postTypeDescription = [];
		if ( isset( $postTypeDescription[ $postType ] ) ) {
			return $postTypeDescription[ $postType ];
		}

		if ( aioseo()->options->searchAppearance->dynamic->postTypes->has( $postType ) ) {
			$description = aioseo()->options->searchAppearance->dynamic->postTypes->{$postType}->metaDescription;
		}

		$postTypeDescription[ $postType ] = empty( $description ) ? '' : $description;

		return $postTypeDescription[ $postType ];
	}

	/**
	 * Returns the term description.
	 *
	 * @since 4.0.6
	 *
	 * @param  WP_Term $term    The term object.
	 * @param  boolean $default Whether we want the default value, not the post one.
	 * @return string           The term description.
	 */
	public function getTermDescription( $term, $default = false ) {
		static $terms = [];
		if ( isset( $terms[ $term->term_id ] ) ) {
			return $terms[ $term->term_id ];
		}

		$description = '';
		if (
			in_array( 'autogenerateDescriptions', aioseo()->internalOptions->deprecatedOptions, true ) &&
			! aioseo()->options->deprecated->searchAppearance->advanced->autogenerateDescriptions
		) {
			$terms[ $term->term_id ] = $description;
			return $description;
		}

		$options = aioseo()->options->noConflict();
		if ( ! $description && $options->searchAppearance->dynamic->taxonomies->has( $term->taxonomy ) ) {
			$description = $this->helpers->prepare( aioseo()->options->searchAppearance->dynamic->taxonomies->{$term->taxonomy}->metaDescription, false, $default );
		}

		$terms[ $term->term_id ] = $description ? $description : $this->helpers->prepare( term_description( $term->term_id ), false, $default );
		return $terms[ $term->term_id ];
	}
}