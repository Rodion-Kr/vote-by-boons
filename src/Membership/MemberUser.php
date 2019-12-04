<?php namespace Codeable\Poll\Membership;

use WP_User;

/**
 * Class MemberUser
 * @package Codeable\Poll\Membership
 */
class MemberUser {

	/**
	 *
	 */
	const BOONS_TOTAL_META_KEY = '_boons_total';

	/**
	 * @var WP_User
	 */
	private $user;

	/**
	 * MemberUser constructor.
	 *
	 * @param WP_User $user
	 */
	public function __construct( WP_User $user ) {
		$this->user = $user;
	}

	/**
	 * @return int
	 */
	public function getTotalScore() {
		return (int) $this->getMeta( self::BOONS_TOTAL_META_KEY );
	}

	/**
	 * @param $total
	 */
	public function setTotalScore( $total ) {
		$this->setMeta( self::BOONS_TOTAL_META_KEY, $total );
	}

	/**
	 * @param $boons
	 */
	public function addToScore( $boons ) {
		$score = $this->getTotalScore() + $boons;

		$this->setTotalScore( $score );
	}

	/**
	 * @param $boons
	 */
	public function removeFromScore( $boons ) {
		$score = $this->getTotalScore() - $boons;

		$this->setTotalScore( max( 0, $score ) );
	}

	/**
	 * @param $metaKey
	 * @param $value
	 *
	 * @return bool|int
	 */
	protected function setMeta( $metaKey, $value ) {
		return update_user_meta( $this->user->ID, $metaKey, $value );
	}

	/**
	 * @param $metaKey
	 *
	 * @return mixed
	 */
	protected function getMeta( $metaKey ) {
		return get_user_meta( $this->user->ID, $metaKey, true );
	}
}