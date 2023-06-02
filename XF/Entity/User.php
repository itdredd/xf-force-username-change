<?php

namespace Dredd\ForceChangeUsername\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public function canForceChangeUsername(&$error = null)
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id || $this->user_id == $visitor->user_id) {
            return false;
        }

        return true;
    }
}