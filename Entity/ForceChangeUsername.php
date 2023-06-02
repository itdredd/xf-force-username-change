<?php

namespace Dredd\ForceChangeUsername\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int $request_id
 * @property int $user_id
 * @property int $staff_user_id
 */
class ForceChangeUsername extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_dfcu_force_change_username';
        $structure->shortName = 'Dredd\ForceChangeUsername:ForceChangeUsername';
        $structure->primaryKey = 'request_id';

        $structure->columns = [
            'request_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'staff_user_id' => ['type' => self::UINT, 'required' => true],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ],
            'Staff' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'staff_user_id',
            ],
        ];;

        return $structure;
    }
}