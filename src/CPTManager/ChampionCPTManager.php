<?php namespace Codeable\Poll\CPTManager;

class ChampionCPTManager {

	const POST_TYPE = 'champions';

	const TAXONOMY_SLUG = 'clans';

	public function __construct() {
		add_action( 'init', [ $this, 'registerCPT' ] );
		add_action( 'init', [ $this, 'registerTaxonomy' ] );
	}

	public function registerTaxonomy() {
		$labels = array(
			'name'              => 'Clans',
			'singular_name'     => 'Clan',
			'search_items'      => __( 'Search Clans' ),
			'all_items'         => __( 'All Clans' ),
			'parent_item'       => __( 'Parent Clan' ),
			'parent_item_colon' => __( 'Parent Clan:' ),
			'edit_item'         => __( 'Edit Clan' ),
			'update_item'       => __( 'Update Clan' ),
			'add_new_item'      => __( 'Add New Clan' ),
			'new_item_name'     => __( 'New Clan' ),
			'menu_name'         => __( 'Clans' ),
		);

		register_taxonomy( self::TAXONOMY_SLUG, array( self::POST_TYPE ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => false,
		) );
	}

	public function registerCPT() {
		register_post_type( self::POST_TYPE, [
			'labels'             => [
				'name'          => 'Champions',
				'singular_name' => 'Champion',
			],
			'taxonomies'         => [ self::TAXONOMY_SLUG ],
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title' ],
			'menu_icon'          => 'dashicons-businessperson'
		] );
	}
}