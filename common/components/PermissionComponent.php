<?php

namespace common\components;

/**
 * Description of PermissionComponent
 *
 * @author Pawan Kumar
 */
class PermissionComponent extends \yii\base\Component
{
    public $permission;
    public $categories;
    public $classSection;
    
    private $globalAccessRoutes = [
        'user/edit', 'user/save-image', 'home/index', 'home/remove', 'home/featured-media',
        'upload-file/upload', 'upload-file/upload-modal', 'class-group/section', 'student/section', 'question-bank/get-sections'
    ];
    
    private $staffRoutes = [
        'leave/index', 'salary/index', 'increment/index', 'library/index', 'income-tax/index', 'user/settings', 'attendance/index', 'attendance/view', 'attendance/mark', 'attendance/viewmarked', 'attendance/markedattendance', 'result/index', 'result/view', 'result/download-report-card', 'registration/index/confirm-payment', 'registration/index/export', 'message/student-message/student-list', 'message/student-message/send-message', 'home/section'
    ];

    public function setup($userId)
    {
        if ((int) $userId <= 0) {
            return false;
        }

        $permissionModel = \common\models\Permission::find()
                ->innerJoin('user_permission', 'user_permission.permission_id = permission.id')
                ->where('user_permission.user_id =:userId', [':userId' => $userId])
                ->asArray()
                ->all();

        $list = [];
        if ($permissionModel !== NULL) {
            $i = 0;
            foreach ($permissionModel as $permission) {
                $list[$permission['controller']][$i]['id'] = $permission['id'];
                $list[$permission['controller']][$i]['name'] = $permission['name'];
                $list[$permission['controller']][$i]['alias'] = $permission['alias'];
                $list[$permission['controller']][$i]['action'] = $permission['action'];
                $list[$permission['controller']][$i]['route'] = $permission['route'];
                $i++;
            }
        }

        $this->permission = $list;
        $this->setCategory($userId);
    }
    
    private function setCategory($userId)
    {
        $categoryModel = \common\models\CategoryPermission::find()
                ->select(['category_id'])
                ->where('user_id =:userId', [':userId' => $userId])
                ->asArray()
                ->all();
        
        $list = [];
        if ($categoryModel !== null) {
            foreach ($categoryModel as $cat) {
                $list[] = $cat['category_id'];
            }
        }
        
        $this->categories = $list;
    }
    
    public function checkAccess($permissionName)
    {   
        if (!isset($this->permission) || empty($this->permission)) {
            return FALSE;
        }
        
        if(\Yii::$app->role->isUserSuperAdminRole()) {
            return TRUE;
        }
 
        $accessAllowed = FALSE;
        foreach ($this->permission as $actionList) {
            foreach ($actionList as $data) {
                if (trim($data['name']) == $permissionName) {
                    $accessAllowed =  TRUE;
                    break 1;
                }
            }
        }
  
        return $accessAllowed;
    }
    
    public function checkRoute($route)
    { 
        if (in_array($route, $this->globalAccessRoutes)) {
            return TRUE;
        }
        
        if (!isset($this->permission) || empty($this->permission)) {
            return FALSE;
        }

        $accessAllowed = FALSE;
       
        foreach ($this->permission as $actionList) {
            foreach ($actionList as $data) {
                if ($data['route'] === $route) {
                    $accessAllowed = TRUE;
                    break 1;
                }
                if(\Yii::$app->role->isUserHasStaffRole() && in_array($route, $this->staffRoutes)) {
                   $accessAllowed = TRUE;
                    break 1; 
                }
            }
        }

        return $accessAllowed;
    }

    public function checkCategoryAccess($catId)
    {
        if (!isset($this->categories) || empty($this->categories)) {
            return FALSE;
        }
        
        $accessAllowed = FALSE;
        if (in_array($catId, $this->categories)) {
            $accessAllowed = TRUE;
        }

        return $accessAllowed;
    }

}
