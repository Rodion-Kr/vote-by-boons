<?php namespace Codeable\Poll\Membership;

use WC_Memberships_Integration_Subscriptions_User_Membership;
use WC_Memberships_User_Membership;
use WC_Subscription;
use WP_User;

/**
 * Class MemberManager
 * @package Codeable\Poll\Membership
 */
class MemberManager {

	/**
	 * MemberManager constructor.
	 */
	public function __construct() {
		// Render
		add_action( 'show_user_profile', [ $this, 'renderMemberFields' ] );
		add_action( 'edit_user_profile', [ $this, 'renderMemberFields' ] );
		// Save
		add_action( 'personal_options_update', [ $this, 'saveMemberFields' ] );
		add_action( 'edit_user_profile_update', [ $this, 'saveMemberFields' ] );

		// After membership cancelled
		add_action( 'wc_memberships_user_membership_cancelled', [ $this, 'setUsersBoonsToZero' ] );

		add_filter( 'wc_memberships_grant_access_from_new_purchase', [ $this, 'disableAllPreviousMemberships' ], 10,
			2 );
	}

	public function disableAllPreviousMemberships( $grantAccess, $args ) {

		$order = wc_get_order( $args['order_id'] );

		if ( wcs_order_contains_renewal( $order ) ) {
			return $grantAccess;
		}

		$activeMemberships = wc_memberships_get_user_memberships( $args['user_id'] );

		foreach ( $activeMemberships as $membership ) {

			$membership = new WC_Memberships_Integration_Subscriptions_User_Membership( $membership->get_id() );

			if ( $membership instanceof WC_Memberships_Integration_Subscriptions_User_Membership ) {
				$subscription = $membership->get_subscription();

				if ( $subscription && $subscription instanceof WC_Subscription ) {
					$subscription->delete( true );
				}
			}

			$membership->cancel_membership( 'User has purchased another membership' );
		}

		return $grantAccess;
	}

	public function setUsersBoonsToZero( WC_Memberships_User_Membership $membership ) {
		$member = new MemberUser( $membership->get_user() );

		$member->setTotalScore( 0 );
	}

	/**
	 * @param WP_User $user
	 */
	public function renderMemberFields( WP_User $user ) {
		$memberUser = new MemberUser( $user );
		?>
        <h3>Boons</h3>
        <table class="form-table">
            <tr>
                <th><label for="user_boons_count"><?php _e( "User boons" ); ?></label></th>
                <td>
                    <input type="number" min="0" step="1" name="user_boons_count" id="user_boons_count"
                           value="<?php echo esc_attr( $memberUser->getTotalScore() ); ?>"
                           class="regular-text"/><br/>
                    <span class="description"><?php _e( "User's boons total" ); ?></span>
                </td>
            </tr>
        </table>
		<?php
	}

	/**
	 * @param $user_id
	 */
	public function saveMemberFields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		$user = new WP_User( $user_id );

		if ( $user->ID > 0 && isset( $_POST['user_boons_count'] ) ) {
			$boonsCount = intval( $_POST['user_boons_count'] );
			$memberUser = new MemberUser( $user );
			$memberUser->setTotalScore( $boonsCount );
		}
	}
}