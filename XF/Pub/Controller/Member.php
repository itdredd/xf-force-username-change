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

        /** @var \Dredd\ForceChangeUsername\Entity\ForceChangeUsername $request */
        $existRequest = $this->finder('Dredd\ForceChangeUsername:ForceChangeUsername')
            ->where('user_id', $user->user_id)->fetchOne();

        if ($existRequest) {
            return $this->message(\XF::phrase('dfcu_exist_request'));
        }


        $request = \XF::em()->create('Dredd\ForceChangeUsername:ForceChangeUsername');
        $request->bulkSet([
            'user_id' => $user->user_id,
            'staff_user_id' => \XF::visitor()->user_id
        ]);
        $request->save();

        return $this->message(\XF::phrase('dfcu_success'));
    }
}