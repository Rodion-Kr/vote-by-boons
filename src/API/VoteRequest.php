<?php namespace Codeable\Poll\API;

use Codeable\Poll\Entity\Champion;
use Codeable\Poll\Entity\Poll;
use Codeable\Poll\EntityMapper\ChampionMapper;
use Codeable\Poll\EntityMapper\PollMapper;
use Codeable\Poll\Membership\MemberUser;
use WP_User;
use Exception;

class VoteRequest {
	/**
	 * @var Poll|null
	 */
	private $poll;
	/**
	 * @var Champion|null
	 */
	private $champion;
	/**
	 * @var int
	 */
	private $boons;
	/**
	 * @var MemberUser
	 */
	private $member;
	/**
	 * @var null
	 */
	private $nonce;

	/**
	 * VoteRequest constructor.
	 *
	 * @param Poll|null $poll
	 * @param Champion|null $champion
	 * @param int $boons
	 * @param MemberUser|null $member
	 * @param null $nonce
	 */
	public function __construct(
		Poll $poll = null,
		Champion $champion = null,
		$boons = 1,
		MemberUser $member = null,
		$nonce = null
	) {

		$this->poll     = $poll;
		$this->champion = $champion;
		$this->boons    = $boons;
		$this->member   = $member;
		$this->nonce    = $nonce;
	}

	/**
	 * @return MemberUser
	 */
	public function getMember() {
		return $this->member;
	}

	/**
	 * @return Poll
	 */
	public function getPoll() {
		return $this->poll;
	}

	/**
	 * @return Champion
	 */
	public function getChampion() {
		return $this->champion;
	}

	/**
	 * @return int
	 */
	public function getBoons() {
		return $this->boons;
	}

	/**
	 * @return null
	 */
	public function getNonce() {
		return $this->nonce;
	}


	/**
	 * @return VoteRequest
	 */
	public static function createFromGlobals() {
		$nonce     = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : null;
		$poll      = isset( $_POST['poll_id'] ) ? PollMapper::getById( intval( $_POST['poll_id'] ) ) : null;
		$champion  = isset( $_POST['champion_id'] ) ? ChampionMapper::getById( intval( $_POST['champion_id'] ) ) : null;
		$boonCount = isset( $_POST['boon_count'] ) ? absint( $_POST['boon_count'] ) : null;
		$member    = is_user_logged_in() ? new MemberUser( new WP_User( get_current_user_id() ) ) : null;

		return new self( $poll, $champion, $boonCount, $member, $nonce );
	}

	/**
	 * Validate data
	 * @throws Exception
	 */
	public function validate() {

		if ( ! $this->getMember() instanceof MemberUser ) {
			throw new Exception( 'User is not authenticate', 100 );
		}

		if ( $this->getMember()->getTotalScore() < $this->getBoons() ) {
			throw new Exception( 'User has no required boons count', 101 );
		}

		if ( ! $this->getPoll() instanceof Poll ) {
			throw new Exception( 'Poll does not exists', 200 );
		} elseif ( ! $this->getPoll()->isActive() ) {
			throw new Exception( 'Poll is not active', 201 );
		}

		if ( ! $this->getChampion() instanceof Champion ) {
			throw new Exception( 'Champion does not exists', 300 );
		}

		$foundChampion = false;

		foreach ( $this->getPoll()->getPollChampions() as $champion ) {
			if ( $champion->getChampion()->getId() == $this->getChampion()->getId() ) {
				$foundChampion = true;
				break;
			}
		}

		if ( ! $foundChampion ) {
			throw new Exception( 'Champion does not tied to poll', 301 );
		}

		if ( ! wp_verify_nonce( $this->getNonce(), AJAX::VOTE_ACTION ) ) {
			throw new Exception( 'Invalid nonce', 400 );
		}
	}
}