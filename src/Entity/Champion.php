<?php namespace Codeable\Poll\Entity;

class Champion {

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var Clan
	 */
	private $clan;

	/**
	 * @var string
	 */
	private $image;

	/**
	 * Champion constructor.
	 *
	 * @param int $id
	 * @param string $name
	 * @param string $image
	 * @param Clan $clan
	 */
	public function __construct( $id, $name, $image, Clan $clan = null ) {
		$this->id   = $id;
		$this->name = $name;
		$this->clan = $clan;
		$this->image = $image;
	}

	public function getData() {
		return [
			'id'   => $this->getId(),
			'name' => $this->getName(),
			'image' => $this->getImage(),
			'clan' => $this->clan ? $this->getClan()->getData() : null,
		];
	}

	public function getImage() {
		return $this->image;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return (int) $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return Clan
	 */
	public function getClan() {
		return $this->clan;
	}

}