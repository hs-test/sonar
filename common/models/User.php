<?php

namespace common\models;

use common\models\base\User as BaseUser;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * Description of User
 *
 * @author Pawan Kumar
 */
class User extends BaseUser implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    const ROLE_ADMIN = 1;
    const ROLE_CALLCENTER_EXECUTIVE = 2;
    const ROLE_DISPATCH_EXECUTIVE = 3;
    const ROLE_DEALING_HEAD = 4;
    const ROLE_ASSIGNMENT_OFFICER = 5;
    const ROLE_ACCOUNT_MANAGER = 6;
    const ROLE_CALLCENTER_SUPERVISOR = 7;
    const ROLE_SUPERADMIN = 8;
    const ROLE_ASSISTANT_ACCOUNT_MANAGER = 9;
    const ROLE_ACCOUNT_EXECUTIVE = 10;
    const ROLE_SUPERVISOR = 11;
    
    const IS_LAST_ALLOCATED_YES = 1;
    const IS_LAST_ALLOCATED_NO = 0;
    const SEARCH_BY_USERNAME = 'username';
    const SEARCH_BY_EMAIL = 'email';
    const USERNAME_REGEX = '^a-zA-Z0-9_-';
    
    const BACKEND_LOGIN_KEY = 'backend_login_authentication';
    const BACKEND_FIXATION_COOKIE = 'backend_fixation_cookie';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_on', 'updated_on'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_on'],
                ],
            ],
            \components\behaviors\GuidBehavior::className(),
            [
                'class' => \components\behaviors\PurifyStringBehavior::className(),
                'attributes' => ['username','name','email','mobile']
            ],
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->role_id === self::ROLE_SUPERADMIN) {
                $this->addError('role_id', 'Please select valid role.');
                return false;
            }
            if ($this->role_id === self::ROLE_DEALING_HEAD) {
                $this->allowed_grievance = \Yii::$app->params['allowed.grievance'];
            }
        }
        return parent::beforeSave($insert);
    }

    public function rules()
    {
        $rules = parent::rules();
        $myRules = [
            [['username'], 'match', 'pattern' => '/[' . self::USERNAME_REGEX . ']/', 'not' => true, 'message' => 'Username contains invalid characters. Only alphanumeric - _ are allowed.'],
            ['username', 'filter', 'filter' => function($value) {
                    return preg_replace("/[" . self::USERNAME_REGEX . "]/", '', $value);
                }],
            [['username'], 'unique'],
            ['allowed_grievance', 'validateAllowedGrievance', 'on' => ['allocate']]
        ];

        return \yii\helpers\ArrayHelper::merge($rules, $myRules);
    }

    public function validateAllowedGrievance($attribute, $params)
    {

        if ($this->allocated_grievance > $this->allowed_grievance) {
            $this->addError($attribute, 'Allowed SRN must be greater than allocated SRN');
        }
    }
    
    public static function getUserList($params = [])
    {
        $list = [];
        $usersAQ = User::find()
                ->select(['user.id', 'user.username'])
                ->where('user.status = :status', [':status' => self::STATUS_ACTIVE]);

        if (isset($params['role_id']) && !empty($params['role_id'])) {
            $usersAQ->andWhere('user.role_id = :roleId', [':roleId' => $params['role_id']]);
        }
        
        $usersAQ->orderBy(['name' => SORT_ASC]);
        $users = $usersAQ->asArray()
                ->all();
        foreach ($users as $user):
            $list[$user['id']] = strtoupper($user['username']);
        endforeach;

        return $list;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function findByUsernameAndRole($username, $roleId)
    {
        return static::findOne(['username' => $username, 'role_id' => $roleId]);
    }
    
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findByEmailAndRole($email, $roleId)
    {
        return static::findOne(['email' => $email, 'role_id' => $roleId]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id; //now primary key is a composite key id+guid
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Assign passed attributes & save user record
     * @param array $attributes
     * @return boolean
     */
    public function saveUser($attributes)
    {
        if (empty($attributes)) {
            return FALSE;
        }

        //echo '<pre>';print_r($attributes);die;
        //new user
        if (!isset($attributes['id']) || (int) $attributes['id'] <= 0) {
            $this->loadDefaultValues(TRUE);
            $this->generateAuthKey();
            $this->attributes = $attributes;
            $this->setAttribute('status', User::STATUS_ACTIVE);
            $this->setPassword($attributes['password']);
        }
        //existing user
        else if ((int) $attributes['id'] > 0) {
             if (isset($attributes['name']) && !empty($attributes['name'])) {
                $this->setAttribute('name', $attributes['name']);
            }
            
            if (isset($attributes['username']) && !empty($attributes['username'])) {
                $this->setAttribute('username', $attributes['username']);
            }
            if (isset($attributes['email']) && !empty($attributes['email'])) {
                $this->setAttribute('email', $attributes['email']);
            }
            if (isset($attributes['mobile']) && !empty($attributes['mobile'])) {
                $this->setAttribute('mobile', $attributes['mobile']);
            }
            if (isset($attributes['role_id']) && !empty($attributes['role_id'])) {
                $this->setAttribute('role_id', $attributes['role_id']);
            }
            
            if (isset($attributes['status']) && in_array($attributes['status'], [self::STATUS_DELETED, self::STATUS_ACTIVE])) {
                $this->setAttribute('status', (int) $attributes['status']);
            }
            if (isset($attributes['password']) && !empty($attributes['password'])) {
                $this->setPassword($attributes['password']);
            }
        }

        if ($this->save()) {
            return $this->id;
        }

        return FALSE;
    }
    
    private static function findByParams($params = [])
    {
        $modelAQ = User::find();

        if (isset($params['selectCols']) && !empty($params['selectCols'])) {
            $modelAQ->select($params['selectCols']);
        }
        else {
            $modelAQ->select('user.*');
        }

        if (isset($params['id'])) {
            $modelAQ->andWhere('user.id =:id', [':id' => $params['id']]);
        }

        if (isset($params['guid'])) {
            $modelAQ->andWhere('user.guid =:guid', [':guid' => $params['guid']]);
        }
        
        if (isset($params['email'])) {
            $modelAQ->andWhere('user.email =:email', [':email' => $params['email']]);
        }
        
        if (isset($params['username'])) {
            $modelAQ->andWhere('user.username =:username', [':username' => $params['username']]);
        }
        
        if (isset($params['isLastAllocated'])) {
            $modelAQ->andWhere('user.is_last_allocated =:isLastAllocated', [':isLastAllocated' => $params['isLastAllocated']]);
        }
        
        if (isset($params['isLimitAcheived'])) {
            $modelAQ->andWhere('user.is_limit_achieved =:isLimitAcheived', [':isLimitAcheived' => $params['isLimitAcheived']]);
        }
        
        if (isset($params['nextDhUserId'])) {
            $modelAQ->andWhere('user.id >=:nextDhUserId', [':nextDhUserId' => $params['nextDhUserId']]);
        }

        if(isset($params['joinUserLocation'])) {
            $modelAQ->{$params['joinUserLocation']}('user_location', 'user_location.user_id = user.id');  
        }
        
        if (isset($params['joinWithState'])) {
            $modelAQ->{$params['joinWithState']}('state', 'user_location.state_code = state.code');
        }
        
        if (isset($params['joinWithDiscom'])) {
            $modelAQ->{$params['joinWithDiscom']}('discom', 'user.discom_id = discom.id');
        }

        if (isset($params['roleId'])) {
            if(is_array($params['roleId'])){
                $modelAQ->andWhere(['in', 'user.role_id', $params['roleId']]);
            }else{
                $modelAQ->andWhere('user.role_id =:roleId', [':roleId' => $params['roleId']]);
            }
        }
        if (isset($params['userNotIn'])) {
            $modelAQ->andWhere(['NOT IN', 'user.id', $params['userNotIn']]);
        }

        if (isset($params['discomId'])) {
            $modelAQ->andWhere('user.discom_id =:discomId', [':discomId' => $params['discomId']]);
        }
        
        if (isset($params['stateCode'])) {
            $modelAQ->andWhere('user_location.state_code =:stateCode', [':stateCode' => $params['stateCode']]);
        }
        
        if (isset($params['districtCode'])) {
            $modelAQ->andWhere('user_location.district_code =:districtCode', [':districtCode' => $params['districtCode']]);
        }
        
        if (isset($params['status'])) {
            $modelAQ->andWhere('user.status =:status', [':status' => $params['status']]);
        }
        
        if (isset($params['notEmptyAllowedGrievance'])) {
            $modelAQ->andWhere('user.allowed_grievance IS NULL OR user.allowed_grievance!=:notEmptyAllowedGrievance', [':notEmptyAllowedGrievance' => $params['notEmptyAllowedGrievance']]);
        }
         
        // echo $modelAQ->createCommand()->rawSql;

        return (new caching\ModelCache(self::className(), $params))->getOrSetByParams($modelAQ, $params);
    }
    
    public static function findById($id, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['id' => $id], $params));
    }
    
    public static function findByRoleId($roleId, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['roleId' => $roleId], $params));
    }
    
    public static function findByGuid($guid, $params = [])
    {
        return self::findByParams(\yii\helpers\ArrayHelper::merge(['guid' => $guid], $params));
    }
    
    public static function roleArray($key = null)
    {
        $roles = [
            self::ROLE_CALLCENTER_EXECUTIVE => 'CALL CENTER EXECUTIVE',
            self::ROLE_CALLCENTER_SUPERVISOR => 'CALL CENTER SUPERVISOR',
            self::ROLE_DISPATCH_EXECUTIVE => 'DISPATCH EXECUTIVE',
            self::ROLE_DEALING_HEAD => 'DEALING HEAD',
            self::ROLE_ASSIGNMENT_OFFICER => 'ASSIGNMENT OFFICER',
            self::ROLE_ACCOUNT_MANAGER => 'ACCOUNT MANAGER',
            self::ROLE_ASSISTANT_ACCOUNT_MANAGER => 'ASSISTANT ACCOUNT MANAGER',
            self::ROLE_ACCOUNT_EXECUTIVE => 'ACCOUNT EXECUTIVE',
            self::ROLE_SUPERVISOR => 'SUPERVISOR',
        ];

        return isset($roles[$key]) ? $roles[$key] : $roles;
    }

    public static function findUserModel($params)
    {
        return self::findByParams($params);
    }
    
    public static function findUserTargetNew($userId, $month = [])
    {

        $userModel = \common\models\UserTargetLog::find()
                ->select(['month', 'year', 'date', 'allocated', 'created_on'])
                ->where('user_target_log.user_id=:userId', [':userId' => $userId])
                ->andWhere(['IN', 'user_target_log.month', $month])
                ->orderBy(['user_target_log.year' => SORT_DESC, 'user_target_log.month' => SORT_DESC, 'user_target_log.created_on' => SORT_DESC])
                ->asArray()
                ->all();
        $usertarget = 0;
        $monthArray = [];
        if (!empty($userModel)) {
            foreach ($userModel as $user) {
                if (!in_array($user['month'],$monthArray)) {
                    $monthArray[] = $user['month'];
                    $usertarget = $usertarget + $user['allocated'];
                }
            }
        }
        return $usertarget;
    }
    
    public static function findUserTarget($userId, $params, $month = null)
    {

        $userModel = \common\models\UserTargetLog::find()
                ->select(['month', 'year', 'date', 'allocated', 'created_on'])
                ->where('user_target_log.user_id=:userId', [':userId' => $userId])
                ->orderBy(['user_target_log.year' => SORT_DESC, 'user_target_log.month' => SORT_DESC, 'user_target_log.created_on' => SORT_DESC])
                ->asArray()
                ->all();

        $usertarget = 0;
        if (!empty($userModel)) {
            foreach ($userModel as $user) {
                if ($user['month'] == $month) {
                    $usertarget = $user['allocated'];
                    break;
                }
                else {
                    $usertarget = $user['allocated'];
                    break;
                }
            }
        }

        if (isset($params['month']) && is_array($params['month'])) {
            foreach ($params['month'] as $months) {
                $usertarget = $usertarget + self::findUserTarget($userId, [], $months);
            }
        }
        return $usertarget;
    }
    
    public static function beforeUserLogin() 
    {
        $session = Yii::$app->session;
        $session->destroy();
        $session->open();
        $session->regenerateID();
        
        return true;
    }

    public static function afterUserLogin(IdentityInterface $identity)
    {
        if ($identity->id > 0) {
            
            //Session hijacking prevention logic
            self::initSessionHijackingPreventions();
        }

        return true;
    }

    public static function afterUserLogout(IdentityInterface $identity)
    {
        if ($identity->id > 0) {

            $cookies = Yii::$app->response->cookies;
            $cookieName = 'app-frontend';
            $cookies->remove($cookieName, true);
        }

        return true;
    }
    
     public static function initSessionHijackingPreventions()
    {
        $appId = Yii::$app->id;
        if ($appId === 'app-frontend') {
            self::setSessionHijackingPreventions(self::BACKEND_LOGIN_KEY, 1, self::BACKEND_FIXATION_COOKIE);
        }
        
    }

    public static function setSessionHijackingPreventions($sessionKey, $sessionValue, $cookieKey)
    {
        $cookies = Yii::$app->response->cookies;

        // Create a cookie and store in session to prevent man in the middle attack
        $randomSecurityString = Yii::$app->getSecurity()->generateRandomString(32);

        // Set Network Id in session prevent session hijacking
        Yii::$app->session->set($sessionKey, $sessionValue);
        Yii::$app->session->set($cookieKey, $randomSecurityString);

        $cookieParams = [
            'name' => $cookieKey,
            'value' => $randomSecurityString,
            'expire' => time() + 7 * 24 * 60 * 60
        ];
        
        if (Yii::$app->id == 'app-frontend') {
            $sessionObj = Yii::$app->get('session');
            $sessionCookieParams = $sessionObj->getCookieParams();
            $cookieParams['domain'] = $sessionCookieParams['domain'];
        }
        
        $cookies->add(new \yii\web\Cookie($cookieParams));

        return true;
    }

    public static function checkSessionHijackingPreventions($sessionKey, $cookieKey, $sessionValueToCheck = 1)
    {
        if (\components\Helper::isTestingApplication()) {
            return true;
        }

        $cookies = Yii::$app->request->cookies;
        $session = Yii::$app->session;

        // Check for seesion and cookie key 
        if (!$session->has($sessionKey) || !$session->has($cookieKey) || !$cookies->has($cookieKey)) {
            return false;
        }

        if ($session->get($sessionKey) != $sessionValueToCheck) {
            return false;
        }

        // check if cookie value and session value are same
        if ($cookies->get($cookieKey)->value != $session->get($cookieKey)) {
            return false;
        }

        return true;
    }

}
