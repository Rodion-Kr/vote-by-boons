<?php namespace Codeable\Poll\WooCommerce;

use Codeable\Poll\Membership\MemberUser;
use Exception;
use Premmerce\SDK\V2\FileManager\FileManager;
use WC_Order_Item_Product;
use WC_Product;
use WP_Post;
use WP_User;

/**
 * Class WooCommerce
 * @package Codeable\Poll\WooCommerce
 */
class WooCommerce {
	/**
	 * @var FileManager
	 */
	private $manager;

	/**
	 * WooCommerce constructor.
	 *
	 * @param FileManager $manager
	 */
	public function __construct( FileManager $manager ) {

		$this->manager = $manager;

		add_action( 'woocommerce_product_options_general_product_data', [ $this, 'addBoonsField' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'updateMeta' ] );

		add_action( 'woocommerce_payment_complete', [ $this, 'awardBoons' ] );
		add_action( 'woocommerce_order_status_completed', [ $this, 'awardBoons' ] );


		add_action( 'woocommerce_variation_options_pricing', function ( $loop, $variation_data, WP_Post $variation ) {
			?>
            <div class="show_if_variable-subscription">
				<?php
				woocommerce_wp_text_input( array(
					'id'    => '_boons_count[' . $loop . ']',
					'value' => get_post_meta( $variation->ID, '_boons_count', true ),
					'label' => __( 'Boons count' ),
				) ); ?>
            </div>
			<?php


		}, 10, 3 );

		add_action( 'woocommerce_save_product_variation', function ( $variation_id, $i ) {

			$boonsCount = $_POST['_boons_count'][ $i ];

			if ( isset( $boonsCount ) ) {
				update_post_meta( $variation_id, '_boons_count', esc_attr( $boonsCount ) );
			}

		}, 10, 2 );

	}

	/**
	 * Award user for purchasing order which contains product with boons
	 *
	 * @param int $orderId
	 */
	public function awardBoons( $orderId ) {

		$order  = wc_get_order( $orderId );
		$user   = new WP_User( $order->get_customer_id() );
		$member = new MemberUser( $user );

		if ( $order && $user->ID > 0 ) {

			foreach ( $order->get_items() as $orderItem ) {
				if ( $orderItem instanceof WC_Order_Item_Product ) {
					try {

						$productId = $orderItem->get_product()->is_type( 'variation' ) ? $orderItem->get_variation_id() : $orderItem->get_product_id();

						$boonsCount = (int) get_post_meta( $productId, '_boons_count', true );

						if ( $boonsCount > 0 && wc_get_order_item_meta( $orderItem->get_id(), 'received boons',
								true ) !== 'yes' ) {

                            // Reset boons count after renewal/purchasing if it is a free membership
						    if ( $orderItem->get_total() > 0 ) {
								$member->addToScore( $boonsCount * $orderItem->get_quantity() );
							} else {
								$member->setTotalScore( $boonsCount * $orderItem->get_quantity() );
							}

							$order->add_order_note( 'User received ' . $boonsCount * $orderItem->get_quantity() . ' boons for purchasing ' . $orderItem->get_name() );

							wc_update_order_item_meta( $orderItem->get_id(), 'received boons', 'yes' );
						}

					} catch ( Exception $e ) {
						wc_get_logger()->add( 'vote_by_boons__errors', $e->getMessage() );
					}

				}
			}
		}
	}

	/**
	 * Render boons fields at the product page
	 */
	public function addBoonsField() {

		/**
		 * @var WC_Product $product_object ;
		 */
		global $product_object;

		?>
        <div class="options_group show_if_simple">
			<?php
			woocommerce_wp_text_input( array(
				'id'    => '_boons_count',
				'value' => get_post_meta( $product_object->get_id(), '_boons_count', true ),
				'label' => __( 'Boons count' ),
			) );
			?>
        </div>
		<?php
	}

	/**
	 * Save boons meta field
	 *
	 * @param int $postId
	 */
	public function updateMeta( $postId ) {
		if ( isset( $_POST['_boons_count'] ) ) {
			update_post_meta( $postId, '_boons_count', intval( $_POST['_boons_count'] ) );
		}
	}
}