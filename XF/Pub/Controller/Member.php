<?php

namespace Dredd\ForceChangeUsername\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionForceChangeUsername(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        if (!$user->canForceChangeUsername()) {
            return $this->noPermission();
        }

        $forceChange = \XF::em()->create('Dredd\ForceChangeUsername:ForceChangeUsername');
        $forceChange->bulkSet([
            'user_id' => $user->user_id,
            'staff_user_id' => \XF::visitor()->user_id
        ]);
        $forceChange->save();

        return $this->message(\XF::phrase('dfcu_success'));
    }
}