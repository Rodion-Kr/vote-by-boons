<?php namespace Codeable\Poll\EntityMapper;

use Codeable\Poll\CPTManager\ChampionCPTManager;
use Codeable\Poll\Entity\Champion;
use WP_Post;

class ChampionMapper {

	/**
	 * @return array
	 */
	public static function getAll() {

		$posts = get_posts( [
			'post_type'      => ChampionCPTManager::POST_TYPE,
			'posts_per_page' => - 1
		] );

		return array_map( function ( WP_Post $post ) {
			return self::getFromWpPost( $post );
		}, $posts );

	}

	/**
	 * @param int $id
	 *
	 * @return Champion|null
	 */
	public static function getById( $id ) {
		$wpPostChampion = get_post( $id );

		if ( $wpPostChampion instanceof WP_Post ) {
			return self::getFromWpPost( $wpPostChampion );
		}

		return null;
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return Champion|null
	 */
	public static function getFromWpPost( WP_Post $post ) {

		if ( $post->post_type === ChampionCPTManager::POST_TYPE ) {
			$image = get_field('champion_image', $post->ID);
			return new Champion( $post->ID, $post->post_name, $image, ClanMapper::getById( self::getClanId( $post ) ) );
		}

		return null;
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return bool|int
	 */
	protected static function getClanId( WP_Post $post ) {
		if ( $post->post_type === ChampionCPTManager::POST_TYPE ) {

			$terms = wp_get_post_terms( $post->ID, ChampionCPTManager::TAXONOMY_SLUG, [
				'fields' => 'ids',
			] );

			if ( is_array( $terms ) ) {
				return $terms[0];
			}
		}

		return null;
	}
}