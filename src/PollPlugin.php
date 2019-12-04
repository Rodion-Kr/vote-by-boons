<?php namespace Codeable\Poll;

use Codeable\Poll\ACF\ACF;
use Codeable\Poll\API\AJAX;
use Codeable\Poll\CPTManager\ChampionCPTManager;
use Codeable\Poll\CPTManager\PollCPTManager;
use Codeable\Poll\Entity\Poll;
use Codeable\Poll\EntityMapper\ChampionMapper;
use Codeable\Poll\EntityMapper\PollMapper;
use Codeable\Poll\Membership\MemberManager;
use Codeable\Poll\Shortcode\PollShortcode;
use Codeable\Poll\WooCommerce\WooCommerce;
use Premmerce\SDK\V2\FileManager\FileManager;

/**
 * Class PollPlugin
 *
 * @package Codeable\Poll
 */
class PollPlugin {

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * PollPlugin constructor.
	 *
	 * @param string $mainFile
	 */
	public function __construct( $mainFile ) {
		$this->fileManager = new FileManager( $mainFile );

		if(!is_admin()) {
		    $this->frontendAssets();
        }
	}

	protected function frontendAssets() {
	    add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('jquery');
	        wp_enqueue_script('main-script', $this->fileManager->locateAsset('main.js'), array('jquery'), null, true);
            wp_enqueue_style( 'main-style', $this->fileManager->locateAsset('main.css'), array());
        });
    }

	/**
	 * Run plugin part
	 */
	public function run() {

		ACF::register();

		new ChampionCPTManager();

		new PollCPTManager();
		new WooCommerce( $this->fileManager );
		new MemberManager();
		new PollShortcode( $this->fileManager );
		new AJAX();

		$this->hooks();
	}

	/**
	 * Load plugin translations
	 */
	public function loadTextDomain() {
		$name = $this->fileManager->getPluginName();
		load_plugin_textdomain( 'vote-by-boons', false, $name . '/languages/' );
	}

	private function hooks() {
		add_action( 'plugins_loaded', [ $this, 'loadTextDomain' ] );

		add_action( 'init', function () {

			$polls = PollMapper::getAll();

			if ( isset( $_GET['test'] ) ) {
				/*wp_send_json( array_map( function ( Poll $poll ) {
					return $poll->getData();
				}, $polls ) );*/

				$champion = ChampionMapper::getById( 69 );
				$poll     = $polls[0];
				if ( $poll instanceof Poll ) {
					$poll->vote( $champion, 10 );
				}
			}

		} );
	}
}