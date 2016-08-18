<?php

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\helpers\TokenHelper;
use api\common\models\UserToken;
use api\common\models\User;
use api\common\components\AccessRule;
use api\modules\v1\models\Bicycle;
use api\modules\v1\models\Station;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class StationController extends CustomActiveController
{
    public $modelClass = '';

    const SEARCHING_RADIUS = 10000; // 10km
    const NEAREST_LIMIT = 10;

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => ['search', 'detail', 'get-all'],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        return $behaviors;
    }

    public function actionSearch() {
        $bodyParams = Yii::$app->request->bodyParams;
        $latitude = $bodyParams['latitude'];
        $longitude = $bodyParams['longitude'];
        $origin = $latitude.','.$longitude;

        $listStation = Yii::$app->db->createCommand('
            select id, 
                   name, 
                   address, 
                   latitude, 
                   longitude, 
                   postal, 
                   bicycle_count, 
                   (select count(bicycle.id)
                    from bicycle
                    where station_id = station.id 
                    and status = :status) as available_bicycle 
             from station
        ')
        ->bindValue(':status', Bicycle::STATUS_FREE)
        ->queryAll();
        $destinations = '';
        for ($iter = 0; $iter < count($listStation); ++$iter) {
            $lat = $listStation[$iter]['latitude'];
            $lng = $listStation[$iter]['longitude'];
            if ($iter > 0) $destinations = $destinations.'|';
            $destinations = $destinations.$lat.','.$lng;
        }
        
        $apiKey = 'AIzaSyCKAnkoocOg8ks6ynhCefc5zeVFHdZ2S_Q';
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?language=en&mode=walking&units=metrics&origins='.$origin.'&destinations='.$destinations.'&key='.$apiKey;
        $json = json_decode(file_get_contents($url));
        $result = $json->rows[0]->elements;

        $stations = [];
        for ($iter = 0; $iter < count($listStation); ++$iter) {
            if ($result[$iter]->status == 'OK') {
                $stations[] = $listStation[$iter];
                $stations[$iter]['distanceText'] = $result[$iter]->distance->text;
                $stations[$iter]['distanceValue'] = $result[$iter]->distance->value;
            }
        }
        
        $cmpStation = function($s1, $s2) {
            return $s1['distanceValue'] - $s2['distanceValue'];
        };
        usort($stations, $cmpStation);
        return array_slice($stations, 0, self::NEAREST_LIMIT);
    }

    public function actionDetail($stationId) {
        $listBikeModel = Yii::$app->db->createCommand('
            select bicycle_type.id as bicycle_type_id, 
                   brand, 
                   model, 
                   bicycle_type.desc,
                   count(case status when :status then 1 else null end) as availableBicycle,
                   count(status) as totalBicycle,
                   (select group_concat(data separator \' \') 
                    from image 
                    where image.bicycle_type_id = bicycle_type.id) as listImageUrl
             from bicycle_type join bicycle on bicycle.bicycle_type_id = bicycle_type.id
             join image on bicycle_type.id = image.bicycle_type_id
             where station_id = :stationId
             group by bicycle_type_id, brand, model
             having availableBicycle > 0
        ')
        ->bindValue(':stationId', $stationId)
        ->bindValue(':status', Bicycle::STATUS_FREE)
        ->queryAll();
        for ($iter = 0; $iter < count($listBikeModel); ++$iter) {
            $listBikeModel[$iter]['listImageUrl'] = explode(' ', $listBikeModel[$iter]['listImageUrl']);
            for ($iterUrl = 0; $iterUrl < count($listBikeModel[$iter]['listImageUrl']); ++$iterUrl) {
                $listBikeModel[$iter]['listImageUrl'][$iterUrl] = Yii::$app->params['BACKEND_BASEURL'].$listBikeModel[$iter]['listImageUrl'][$iterUrl];
            }
        }
        return $listBikeModel;
    }

    public function actionGetAll() {
        $listStation = Yii::$app->db->createCommand('
            select id, 
                   name, 
                   address, 
                   latitude, 
                   longitude, 
                   postal, 
                   bicycle_count
             from station
        ')
        ->queryAll();
        return $listStation;
    }

    // public function afterAction($action, $result)
    // {
    //     $result = parent::afterAction($action, $result);
    //     // your custom code here
    //     return [
    //         'status' => '200',
    //         'data' => $result,
    //     ];
    // }
}