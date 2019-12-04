<?php namespace Codeable\Poll\EntityMapper;

use Codeable\Poll\CPTManager\PollCPTManager;
use Codeable\Poll\Entity\Champion;
use Codeable\Poll\Entity\Poll;
use Codeable\Poll\Entity\PollChampion;
use DateTime;
use WP_Post;

/**
 * Class PollMapper
 * @package Codeable\Poll\EntityMapper
 */
class PollMapper {

	/**
	 * @return self[]
	 */
	public static function getAll() {
		$posts = get_posts( [
			'post_type'      => PollCPTManager::POST_TYPE,
			'posts_per_page' => - 1,
			'post_status'    => 'active',
		] );

		return array_filter( array_map( function ( WP_Post $post ) {
			return self::getFromWpPost( $post );
		}, $posts ) );

	}

	/**
	 * @param $id
	 *
	 * @return Poll|null
	 */
	public static function getById( $id ) {
		$wpPoll = get_post( $id );

		if ( $wpPoll instanceof WP_Post ) {
			return self::getFromWpPost( $wpPoll );
		}

		return null;
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return Poll|null
	 */
	public static function getFromWpPost( WP_Post $post ) {

		if ( $post->post_type === PollCPTManager::POST_TYPE ) {
			try {
				$timeFrame = get_field( 'timeframe', $post->ID );

				$startDate   = isset( $timeFrame['start_date'] ) ? new DateTime( $timeFrame['start_date'] ) : false;
				$endDate     = isset( $timeFrame['end_date'] ) ? new DateTime( $timeFrame['end_date'] ) : false;
				$description = get_field( 'poll_description', $post->ID );

				if ( $startDate && $endDate ) {
					return new Poll( $post->ID, $post->post_title, $description, self::getPollChampions( $post ),
						$startDate,
						$endDate );
				}
			} catch ( \Exception $e ) {
				return null;
			}

		}

		return null;
	}

	/**
	 * @param WP_Post $post
	 *
	 * @return PollChampion[]
	 */
	public static function getPollChampions( WP_Post $post ) {

		if ( $post->post_type === PollCPTManager::POST_TYPE ) {

			$pollData = get_field( 'poll_data', $post->ID );

			$pollData = $pollData ? $pollData : [];

			return array_filter( array_map( function ( array $championData ) {

				$championData = $championData['champion_data'];

				$champion = ChampionMapper::getById( $championData['champion'] );

				if ( $champion instanceof Champion ) {
					return new PollChampion( $champion, (int) $championData['boons_count'], $championData['color'] );
				}

				return false;

			}, $pollData ) );
		}

		return [];
	}

}