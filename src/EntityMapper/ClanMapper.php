<?php namespace Codeable\Poll\EntityMapper;

use Codeable\Poll\CPTManager\ChampionCPTManager;
use Codeable\Poll\Entity\Clan;
use WP_Term;

class ClanMapper {

	public static function getById( $id ) {
		$clanTerm = get_term( $id );

		if ( $clanTerm instanceof WP_Term) {
			return self::getFromTerm( $clanTerm );
		}

		return null;
	}

	public static function getFromTerm( WP_Term $term ) {

		if ( $term->taxonomy === ChampionCPTManager::TAXONOMY_SLUG ) {
			return new Clan( $term->name, get_field( 'clan_logo', $term->taxonomy . '_' . $term->term_id ) );
		}

		return null;
	}
}