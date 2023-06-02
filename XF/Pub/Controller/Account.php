<?php

namespace  Dredd\ForceChangeUsername\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{

    public function actionForceChangeUsername() {
        $form = $this->formAction();
        $visitor = \XF::visitor();

        /** @var \Dredd\ForceChangeUsername\Entity\ForceChangeUsername $request */
        $request = $this->finder('Dredd\ForceChangeUsername:ForceChangeUsername')
            ->where('user_id', $visitor->user_id)->fetchOne();

        if (!$request) {
            return $this->noPermission();
        }

        if ($this->isPost()) {
            $newUsername = $this->filter('username', 'str');

            if ($newUsername !== $visitor->username) {
                $form->basicEntitySave($visitor, [
                    'username' => $newUsername,
                ]);

                $form->complete(function() use ($request)
                {
                    $request->delete();
                });
            }

            $form->run();
            return $this->redirect($this->buildLink('index'));
        }

        return $this->view('XF:Account\ForceChangeUsername', 'dfcu_username_change');
    }
}
