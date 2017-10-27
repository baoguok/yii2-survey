<?php
/**
 * Created by PhpStorm.
 * User: kozhevnikov
 * Date: 10/10/2017
 * Time: 09:51
 */


use common\modules\survey\models\SurveyType;
use kartik\editable\Editable;
use kartik\helpers\Html;
use kartik\widgets\Select2;

use vova07\imperavi\Widget;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $question \common\modules\survey\models\SurveyQuestion */
/* @var $number integer */

Pjax::begin([
    'id' => 'survey-questions-pjax-' . $question->survey_question_id,
    'enablePushState' => false,
    'timeout' => 0,
    'scrollTo' => false,
    'options' => ['class' => 'survey-question-pjax-container'],
    'clientOptions' => [
        'type' => 'post',
        'skipOuterContainers' => true,
    ]
]);

$form = ActiveForm::begin([
    'id' => 'survey-questions-form-' . $question->survey_question_id,
    'action' => Url::toRoute(['question/update-and-close', 'id' => $question->survey_question_id]),
    'validationUrl' => Url::toRoute(['question/validate', 'id' => $question->survey_question_id]),
    'options' => ['class' => 'form-inline', 'data-pjax' => true],
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => "<div class='survey-questions-form-field'>{label}{input}\n{error}</div>",
        'labelOptions' => ['class' => ''],
    ],
]);

echo Html::beginTag('div', ['class' => 'survey-block', 'id' => 'survey-question-' . $question->survey_question_id]);

echo Html::beginTag('div', ['class' => 'survey-question-name-wrap']);
echo ($number + 1) . '. ' . $question->survey_question_name;
echo Html::endTag('div');
echo Html::tag('br', '');

echo Html::beginTag('div', ['class' => 'survey-question-descr-wrap']);
echo $question->survey_question_descr;
echo Html::endTag('div');


echo Html::beginTag('div', ['class' => 'answers-container', 'id' => 'survey-answers-' . $question->survey_question_id]);
if (isset($question->survey_question_type)) {
    echo $this->render('/answers/view/_form', ['question' => $question, 'form' => $form]);
}

echo Html::endTag('div');

echo Html::tag('hr', '');

?>
    <div class="preloader">
        <div class="cssload-spin-box"></div>
    </div>
<?php

echo Html::endTag('div');


ActiveForm::end();

Pjax::end();