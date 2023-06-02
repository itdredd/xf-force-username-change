<?php

namespace Dredd\ForceChangeUsername;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{

        $this->schemaManager()->createTable('xf_dfcu_force_change_username', function (Create $table) {
            $table->addColumn('request_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('staff_user_id', 'int');

            $table->addPrimaryKey('request_id');
            $table->addUniqueKey('user_id');
        });
	}

    public function upgrade(array $stepParams = [])
    {
        // TODO: Implement upgrade() method.
    }

	public function uninstall(array $stepParams = [])
	{
        $this->schemaManager()->dropTable('xf_dfcu_force_change_username');
	}
}