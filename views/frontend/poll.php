<?php use Codeable\Poll\API\AJAX;
use Codeable\Poll\Entity\Poll;


defined( "ABSPATH" ) || die;

/**
 * @var Poll $poll
 */

?>
<script>

    window.voteByBoons = {
        pollId: "<?php echo $poll->getId(); ?>",
        voteUrl: "<?php echo AJAX::getVoteUrl(); ?>",
        updatesUrl: "<?php echo AJAX::getUpdatesUrl(); ?>",
        voteAction:  "<?php echo wp_create_nonce( AJAX::VOTE_ACTION ); ?>",
        createNonce: "<?php echo wp_create_nonce( AJAX::GET_UPDATES_ACTION ); ?>",
        currentUser: Boolean(<?php echo get_current_user_id();  ?>)
    }

</script>

<div id="poll-<?php echo $poll->getId(); ?>"></div>