<?php

namespace Dredd\ForceChangeUsername\XF\Entity;

class User extends XFCP_User
{
    public function canForceChangeUsername(&$error = null)
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id || $this->user_id == $visitor->user_id) {
            return false;
        }

        return $this->isWarnable() && $visitor->hasPermission('general', 'forceChangeUsername');
    }
}