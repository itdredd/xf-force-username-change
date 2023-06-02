<?php

namespace Dredd\ForceChangeUsername;

use \XF\Mvc\Controller;
use \XF\Mvc\ParameterBag;
use \XF\Mvc\Reply\AbstractReply;

class Listener
{

    public static function controller_post_dispatch(Controller $controller, $action,
                                                    ParameterBag $params, AbstractReply &$reply)
    {
        $session = $controller->app()->session();
        $visitor = \XF::visitor();

        //\XF::dump([$session, $controller, $action, $params, $reply]);

        if ($visitor->user_id && !in_array($action, ['Exception', 'ForceChangeUsername']) && !$reply instanceof \XF\Mvc\Reply\Error) {
            $sessionForceChange = $session->get('forceChangeUsername');

            if ($sessionForceChange && $sessionForceChange < \XF::$time) {
                $request = $controller->app()->finder('Dredd\ForceChangeUsername:ForceChangeUsername')
                    ->where('user_id', $visitor->user_id)->fetchOne();

                if ($request) {
                    $reply = $controller->redirect($controller->buildLink('account/force-change-username'));
                }
                else {
                    $session->set('forceChangeUsername', \XF::$time + 1200);
                    $session->save();
                }
            }
            else {
                $session->set('forceChangeUsername', \XF::$time + 1200);
                $session->save();
            }
        }
    }
}
