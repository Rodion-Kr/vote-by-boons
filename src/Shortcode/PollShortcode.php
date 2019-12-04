<?php namespace Codeable\Poll\Shortcode;

use Codeable\Poll\EntityMapper\PollMapper;
use Premmerce\SDK\V2\FileManager\FileManager;

class PollShortcode {

	/**
	 * @var FileManager
	 */
	private $fileManager;

	public function __construct( FileManager $fileManager ) {
		add_shortcode( 'poll', [ $this, 'render' ] );

		$this->fileManager = $fileManager;
	}

	public static function getNameForPoll( $id ) {
		return sprintf( '[poll id=%d]', $id );
	}

    /**
     * @param array $args
     * @return string
     */
	public function render( $args ) {
		$id = isset( $args['id'] ) ? $args['id'] : 0;

		$poll = PollMapper::getById( $id );

		if ( $poll ) {
			return $this->fileManager->renderTemplate( 'frontend/poll.php', [
				'poll' => $poll,
			] );
		}
	}
}