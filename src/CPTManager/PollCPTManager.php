<?php namespace Codeable\Poll\CPTManager;

use Codeable\Poll\Shortcode\PollShortcode;
use WP_Post;

class PollCPTManager {

	const POST_TYPE = 'poll';

	public function __construct() {
		add_action( 'init', [ $this, 'registerCPT' ] );
		add_action( 'add_meta_boxes', [ $this, 'registerShortCodeMetaBox' ] );

		$this->registerShortCodeColumn();
	}

	protected function registerShortCodeColumn() {
		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', function ( $columns ) {
			$columns['shortcode'] = 'Shortcode';

			return $columns;
		} );

		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', function ( $column, $postId ) {
			if ( $column === 'shortcode' ) {
				echo '<code>' . PollShortcode::getNameForPoll( $postId ) . '</code>';
			}
		}, 10, 2 );
	}

	public function registerShortCodeMetaBox() {
		add_meta_box( 'poll-shortcode-metabox', 'Shortcode', [ $this, 'renderShortCodeMetaBox' ], self::POST_TYPE,
			'side' );
	}

	public function renderShortCodeMetaBox() {
		/**
		 * @var WP_Post $post
		 */
		global $post;

		echo '<code>' . PollShortcode::getNameForPoll( $post->ID ) . '</code>';
	}

	public function registerCPT() {
		register_post_type( self::POST_TYPE, [
			'labels'             => [
				'name'          => 'Polls',
				'singular_name' => 'Poll',
				'add_new'       => 'Add Poll',
				'add_new_item'  => 'Add Poll',
				'edit_item'     => 'Edit Poll',
				'new_item'      => 'New Poll',
				'menu_name'     => 'Polls'
			],
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title' ],
			'menu_icon'          => 'dashicons-list-view'
		] );
	}
}