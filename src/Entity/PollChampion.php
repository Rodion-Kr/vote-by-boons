<?php namespace Codeable\Poll\Entity;

class PollChampion {

	/**
	 * @var Champion
	 */
	private $champion;

	/**
	 * @var int
	 */
	private $boonsCount;

	/**
	 * @var string
	 */
	private $color;
	/**
	 * @var null
	 */
	private $percentagePart;

	/**
	 * PollChampion constructor.
	 *
	 * @param Champion $champion
	 * @param int $boonsCount
	 * @param string $color
	 * @param null|float $percentagePart
	 */
	public function __construct( Champion $champion, $boonsCount, $color, $percentagePart = null ) {
		$this->champion       = $champion;
		$this->boonsCount     = $boonsCount;
		$this->color          = $color;
		$this->percentagePart = $percentagePart;
	}

	/**
	 * @return null
	 */
	public function getPercentagePart() {
		return $this->percentagePart;
	}

	/**
	 * @param null $percentagePart
	 */
	public function setPercentagePart( $percentagePart ) {
		$this->percentagePart = $percentagePart;
	}


	public function getData() {
		return [
			'boonsCount'     => $this->getBoonsCount(),
			'color'          => $this->getColor(),
			'percentagePart' => $this->getPercentagePart(),
			'champion'       => $this->getChampion()->getData(),
		];
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
	public function getBoonsCount() {
		return $this->boonsCount;
	}

	/**
	 * @return string
	 */
	public function getColor() {
		return $this->color;
	}

}