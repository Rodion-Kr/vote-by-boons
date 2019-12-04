<?php namespace Codeable\Poll\Entity;

class Clan {

	/**
	 * @var stirng
	 */
	private $name;

	/**
	 * @var string
	 */
	private $logo;

	/**
	 * Clan constructor.
	 *
	 * @param string $name
	 * @param string $logo
	 */
	public function __construct( $name, $logo ) {
		$this->name = $name;
		$this->logo = $logo ? $logo : null;
	}

	public function getData() {
		return [
			'name' => $this->getName(),
			'logo' => $this->getLogo(),
		];
	}

	/**
	 * @return stirng
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getLogo() {
		return $this->logo;
	}

}