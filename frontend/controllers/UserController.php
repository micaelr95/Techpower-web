<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Profile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("The user was not found.");
        }
        
        $profile = Profile::findOne($user->id);
        
        if (!$profile) {
            throw new NotFoundHttpException("The user has no profile.");
        }

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if($user->validate() && $profile->validate()) {
                $profile->save(false);
                $user->save(false);
                Yii::$app->getSession()->setFlash('message', 'Dados guardados com sucesso');
                return $this->redirect(['update', 'id' => $user->id]);
            }
        }

        return $this->render('update', [
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Soft deletes a user
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $model->status = '0';
        $model->save();
        return $this->redirect(['site/index']);
    }
    

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChange_password()
    {
        //Vai buscar o utilizador logado
        $user = Yii::$app->user->identity;

        //Vai buscar os dados inseridos no form
        $formData = $user->load(Yii::$app->request->post());

        if ($formData && $user->validate()){
            $user->password = $user->newPassword;
            $user->save(false);
            Yii::$app->session->setFlash('success', 'Password alterada com sucesso!');
            return $this->redirect(['site/index']);
        }
        return $this->render("change_password", [
        'user' => $user,
        'formData' => $formData,
        ]);
    }
}
