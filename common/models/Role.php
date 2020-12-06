<?php

namespace common\models;

use Yii;
use common\models\base\Role AS BaseRole;

/**
 * Description of Role
 *
 * @author Pawan Kumar
 */
class Role extends BaseRole
{
    const ROLE_ADMIN = 1;
    const ROLE_CALLCENTER_EXECUTIVE = 2;
    const ROLE_DISPATCH_EXECUTIVE = 3;
    const ROLE_DEALING_HEAD = 4;
    const ROLE_ASSIGNMENT_OFFICER = 5;
    const ROLE_ACCOUNT_MANAGER = 6;
    const ROLE_CALLCENTER_SUPERVISOR = 7;

}
