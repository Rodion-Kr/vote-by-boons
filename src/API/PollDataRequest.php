<?php namespace Codeable\Poll\API;

use Codeable\Poll\Entity\Champion;
use Codeable\Poll\Entity\Poll;
use Codeable\Poll\EntityMapper\PollMapper;
use Exception;

class PollDataRequest {
	/**
	 * @var Poll|null
	 */
	private $poll;

	/**
	 * VoteRequest constructor.
	 *
	 * @param Poll|null $poll
	 */
	public function __construct( Poll $poll = null ) {

		$this->poll = $poll;
	}

	/**
	 * @return Poll
	 */
	public function getPoll() {
		return $this->poll;
	}

	/**
	 * @return self
	 */
	public static function createFromGlobals() {
		$poll = isset( $_POST['poll_id'] ) ? PollMapper::getById( intval( $_POST['poll_id'] ) ) : null;
		return new self( $poll );
	}

	/**
	 * Validate data
	 */
	public function validate() {

		if (! $this->getPoll() instanceof Poll ) {
			throw new Exception( 'Poll does not exists', 200 );
		}
	}
}