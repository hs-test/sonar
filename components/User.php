<?php

namespace components;

use Yii;
use common\models\User as BaseUser;

/**
 * Description of User
 *
 * @author Pawan Kumar
 */
class User extends \yii\web\User
{

    public function hasSuperAdminRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_SUPERADMIN) ? TRUE : FALSE;
    }

    public function hasAdminRole()
    {
        return (isset($this->getIdentity()->role_id)) && ($this->getIdentity()->role_id === BaseUser::ROLE_ADMIN || $this->getIdentity()->role_id === BaseUser::ROLE_SUPERADMIN) ? TRUE : FALSE;
    }

    public function hasCallCenterRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_CALLCENTER_EXECUTIVE) ? TRUE : FALSE;
    }

    public function hasCallCenterSupervisor()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_CALLCENTER_SUPERVISOR) ? TRUE : FALSE;
    }

    public function hasDispatchExecuitveRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_DISPATCH_EXECUTIVE) ? TRUE : FALSE;
    }

    public function hasDealingHeadRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_DEALING_HEAD) ? TRUE : FALSE;
    }

    public function hasAssignmentOfficerRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_ASSIGNMENT_OFFICER) ? TRUE : FALSE;
    }

    public function hasAccountManagerRole()
    {
        return (isset($this->getIdentity()->role_id) && ($this->getIdentity()->role_id === BaseUser::ROLE_ACCOUNT_MANAGER || $this->getIdentity()->role_id === BaseUser::ROLE_ACCOUNT_EXECUTIVE || $this->getIdentity()->role_id === BaseUser::ROLE_ASSISTANT_ACCOUNT_MANAGER )) ? TRUE : FALSE;
    }

    public function hasAssistantAccountManagerRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_ASSISTANT_ACCOUNT_MANAGER) ? TRUE : FALSE;
    }

    public function hasAccountExecutiveRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_ACCOUNT_EXECUTIVE) ? TRUE : FALSE;
    }

    public function hasSupervisorRole()
    {
        return (isset($this->getIdentity()->role_id) && $this->getIdentity()->role_id === BaseUser::ROLE_SUPERVISOR) ? TRUE : FALSE;
    }
    
    public function beforeLogin($identity, $cookieBased, $duration)
    {
        \common\models\User::beforeUserLogin();

        return parent::beforeLogin($identity, $cookieBased, $duration);
    }

    public function afterLogin($identity, $cookieBased, $duration)
    {

        \common\models\User::afterUserLogin($identity);

        return parent::afterLogin($identity, $cookieBased, $duration);
    }

    public function afterLogout($identity)
    {
        \common\models\User::afterUserLogout($identity);

        return parent::afterLogout($identity);
    }

}
