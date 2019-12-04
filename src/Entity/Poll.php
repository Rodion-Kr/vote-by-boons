<?php namespace Codeable\Poll\Entity;

use DateTime;
use Exception;

/**
 * Class Poll
 * @package Codeable\Poll\Entity
 */
class Poll {

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var PollChampion[]
	 */
	private $pollChampions;

	/**
	 * @var DateTime
	 */
	private $startDate;

	/**
	 * @var DateTime
	 */
	private $endDate;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * Poll constructor.
	 *
	 * @param $id
	 * @param $name
	 * @param $description
	 * @param array $pollChampions
	 * @param DateTime $startDate
	 * @param DateTime $endDate
	 */
	public function __construct(
		$id,
		$name,
		$description,
		array $pollChampions,
		DateTime $startDate = null,
		DateTime $endDate = null
	) {
		usort( $pollChampions, function ( PollChampion $a, PollChampion $b ) {
			return $a->getBoonsCount() <= $b->getBoonsCount();
		} );

		$this->id            = $id;
		$this->name          = $name;
		$this->description   = $description;
		$this->pollChampions = $pollChampions;
		$this->startDate     = $startDate;
		$this->endDate       = $endDate;

		foreach ( $this->pollChampions as $champion ) {
			$champion->setPercentagePart( $this->getPercentageOfTotal( $champion ) );
		}

	}

	/**
	 * @return array
	 */
	public function getData() {
		return [
			'id'            => $this->getId(),
			'name'          => $this->getName(),
			'description'   => $this->getDescription(),
			'startDate'     => $this->getStartDate()->format( 'Y-m-d H:i:s' ),
			'endDate'       => $this->getEndDate()->format( 'Y-m-d H:i:s' ),
			'isActive'      => $this->isActive(),
			'pollChampions' => array_map( function ( PollChampion $champion ) {
				return $champion->getData();
			}, $this->getPollChampions() )
		];
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		try {
			$now = new DateTime( '@' . current_time( 'timestamp' ) );

			return $now > $this->getStartDate() && $now < $this->getEndDate();
		} catch ( Exception $exception ) {
			wc_get_logger()->add( 'vote_by_boons__errors', $exception->getMessage() );
		}

		return false;
	}

	/**
	 * @return DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @return DateTime
	 */
	public function getEndDate() {
		return $this->endDate;
	}


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return PollChampion[]
	 */
	public function getPollChampions() {
		return $this->pollChampions;
	}

	/**
	 * @return int
	 */
	public function getTotalBoons() {
		return array_reduce( $this->getPollChampions(), function ( $total, PollChampion $champion ) {
			$total += $champion->getBoonsCount();

			return $total;
		}, 0 );
	}

	/**
	 * @param PollChampion $champion
	 *
	 * @return float|int
	 */
	public function getPercentageOfTotal( PollChampion $champion ) {
		if ( $this->getTotalBoons() < 1 ) {
			return 0;
		}

		return $champion->getBoonsCount() / ( $this->getTotalBoons() / 100 );
	}

	/**
	 * @param Champion $champion
	 * @param $boons
	 */
	public function vote( Champion $champion, $boons ) {

		$pollChampions = array_map( function ( array $championData ) use ( $champion, $boons ) {
			if ( $championData['champion_data']['champion'] == $champion->getId() ) {
				$championData['champion_data']['boons_count'] += $boons;
			}

			return $championData;

		}, get_field( 'poll_data', $this->getId() ) );

		update_field( 'poll_data', $pollChampions, $this->getId() );
	}
}