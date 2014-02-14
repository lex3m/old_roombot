<?php

class ManagememberController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array('accessControl', // perform access control for CRUD operations
        'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array( array('allow', // allow admin user to perform 'admin' and 'delete' actions
        'actions' => array('getlastmonthusercount','admin', 'delete', 'index', 'view', 'create', 'update'), 'roles' => array('admin'), ), array('deny', // deny all users
        'users' => array('*'), ), );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this -> render('view', array('model' => $this -> loadModel($id), ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Member;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model -> attributes = $_POST['Member'];
            if ($model -> save())
                $this -> redirect(array('view', 'id' => $model -> id));
        }

        $this -> render('create', array('model' => $model, ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this -> loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model -> attributes = $_POST['Member'];
            if ($model -> save())
                $this -> redirect(array('view', 'id' => $model -> id));
        }

        $this -> render('update', array('model' => $model, ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this -> loadModel($id) -> delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this -> redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex($time, $active) {
        $isActive=$active;
        $criteria = new CDbCriteria();
          
       switch ($time){
           case "day": $timeInterval = 1; break;
           case "week": $timeInterval = 7; break;
           case "month": $timeInterval = 31; break;
           case "all": $timeInterval = 5000; break;
           default: $timeInterval = 5000; break;
       }  
        $start_date  = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-$timeInterval, date("Y")));
        
        if ($active=="yes")
        {
            $criteria->condition = 'activate_type=:active';
            $criteria->params = array(':active'=>1);
        }
        else if ($active=="no") 
        {
            $criteria->condition = 'activate_type=:active';
            $criteria->params = array(':active'=>0); 
        } 
        $criteria->addBetweenCondition('date', $start_date, date('Y-m-d'), 'AND');
        $criteria -> order = 't.id DESC';  
        $criteria -> with = array ('countphotos');
        $dataProvider = new CActiveDataProvider('Member', array('criteria' => $criteria, 'pagination' => array('pageSize' => 12, ), ));
        $this -> render('index', array(
        'dataProvider' => $dataProvider,
        'time'=>$time,
        'isActive'=>$isActive));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Member('search');
        $model -> unsetAttributes();
        // clear any default values
        if (isset($_GET['Member']))
            $model -> attributes = $_GET['Member'];

        $this -> render('admin', array('model' => $model, ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Member the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Member::model() -> findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


    private function resetArray(&$item)
    {
        $item = 0;
    }

    public function actionGetlastmonthusercount($startdate, $enddate, $lastdays, $param) {

        $arrayStartDate= explode(".", $startdate, 3);
        $dayStartDate = $arrayStartDate[0];
        $monthStartDate = $arrayStartDate[1];

        $arrayEndDate= explode(".", $enddate, 3);
        $dayEndDate = $arrayEndDate[0];
        $monthEndDate = $arrayEndDate[1];

        $days = explode(',', $lastdays);

        if ($monthStartDate == 12 && $monthEndDate == 1) {
            $startYear = date('Y') - 1;
        } else {
            $startYear = date('Y');
        }

        $format='Y-m-d';
        $step="+1 day";
        $dates = array();
        $current = strtotime($startYear."-".$monthStartDate."-".$dayStartDate);
        $last = strtotime(date('Y')."-".$monthEndDate."-".$dayEndDate);
    
        while( $current <= $last ) { 
    
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('date', $dates);
        $criteria->group = 'date';

        switch($param) {
            case 'views' :
                $criteria->select = 'views AS cnt, date';
                $countUsersByDateArray = SiteStatistic::model()->findAll($criteria);
            break;
            case 'hosts' :
                $criteria->select = 'hosts as cnt, date';
                $countUsersByDateArray = SiteStatistic::model()->findAll($criteria);
                break;
            case 'register' :
                $criteria->select = 'count(*) AS cnt, date';
                $countUsersByDateArray = Member::model()->findAll($criteria);
            break;
            default:
                $criteria->select = 'count(*) AS cnt, date';
                $countUsersByDateArray = Member::model()->findAll($criteria);
        }

        $i=0; //iterator
        $countUsersByDateForJsonArray=array();
        foreach ($countUsersByDateArray as $countUsersByDate)
        {
            $date = explode('-', $countUsersByDate->date);
            $date = $date[2].'.'.$date[1].'.'.$date[0];
            $countUsersByDateForJsonArray[$date]=$countUsersByDate->cnt;
            $i++;
        }
        $days = array_flip($days);
        array_walk($days, array($this, 'resetArray'));
        $result = array_merge($days, $countUsersByDateForJsonArray);
        $json_array = json_encode(array_values($result));

        echo $json_array;
    }

    /**
     * Performs the AJAX validation.
     * @param Member $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'member-form') {
            echo CActiveForm::validate($model);
            Yii::app() -> end();
        }
    }

}
