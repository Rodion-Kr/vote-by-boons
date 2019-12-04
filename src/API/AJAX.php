<?php namespace Codeable\Poll\API;

use Codeable\Poll\EntityMapper\PollMapper;
use Codeable\Poll\Membership\MemberUser;
use Exception;
use WP_User;

class AJAX
{
    const VOTE_ACTION = 'vote__action';

    const GET_UPDATES_ACTION = 'get_updates__action';

    public function __construct()
    {
        add_action('wc_ajax_' . self::VOTE_ACTION, [$this, 'handleVote']);
        add_action('wc_ajax_' . self::GET_UPDATES_ACTION, [$this, 'handleGetUpdates']);
    }

    public static function getVoteUrl()
    {
        return add_query_arg([
            'wc-ajax' => self::VOTE_ACTION,
        ], site_url());
    }

    public static function getUpdatesUrl()
    {
        return add_query_arg([
            'wc-ajax' => self::GET_UPDATES_ACTION,
        ], site_url());
    }

    public function handleVote()
    {

        try {
            $voteRequest = VoteRequest::createFromGlobals();

            $voteRequest->validate();

            $this->userVote($voteRequest);

            wp_send_json([
                'success' => true,
                'users_boon_count' => $voteRequest->getMember()->getTotalScore(),
                'data' => PollMapper::getById($voteRequest->getPoll()->getId())->getData()
            ]);

        } catch (Exception $exception) {

            $totalBoons = isset($voteRequest) && $voteRequest->getMember() instanceof MemberUser ? $voteRequest->getMember()->getTotalScore() : 0;

            wp_send_json([
                'users_boon_count' => $totalBoons,
                'success' => false,
                'code' => $exception->getCode(),
                'error_message' => $exception->getMessage()
            ]);
        }
    }

    public function handleGetUpdates()
    {

        try {
            $dataRequest = PollDataRequest::createFromGlobals();

            $dataRequest->validate();

            $user = new WP_User(get_current_user_id());

            $boonsCount = 0;

            if ($user->ID > 0) {
                $memberUser = new MemberUser($user);
                $boonsCount = $memberUser->getTotalScore();
            }

            wp_send_json([
                'users_boon_count' => $boonsCount,
                'is_user_logged_in' => $user->ID > 0,
                'success' => true,
                'data' => $dataRequest->getPoll()->getData()
            ]);

        } catch (Exception $exception) {
            wp_send_json([
                'success' => false,
                'code' => $exception->getCode(),
                'error_message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param VoteRequest $request
     */
    public function userVote(VoteRequest $request)
    {
        $request->getMember()->removeFromScore($request->getBoons());
        $request->getPoll()->vote($request->getChampion(), $request->getBoons());
    }

}