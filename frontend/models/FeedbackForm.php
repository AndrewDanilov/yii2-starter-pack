<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * FeedbackForm is the model behind the contact form.
 */
class FeedbackForm extends Model
{
    public $name;
    public $phone;
    public $mark;
    public $company;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['name', 'phone', 'mark', 'company', 'comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
	        'name' => 'Имя',
	        'phone' => 'Телефон',
	        'mark' => 'Переход с',
	        'company' => 'Организация',
	        'comment' => 'Комментарий',
        ];
    }

    /**
     * Sends an email to the webmaster email address using the information collected by this model.
     *
     * @return boolean
     */
    public function sendFeedback()
    {
    	if ($this->validate()) {
    		// возможные передаваемые метки
		    $marks = Yii::$app->params['sendMailMarks'];

		    $data = $this->getAttributes();

		    if (isset($data['mark']) && isset($marks[$data['mark']])) {
			    $template = $marks[$data['mark']];
		    } else {
			    $template = $marks['default'];
		    }

		    $fields = [];
		    foreach ($data as $key => $value) {
		    	if ($key == 'mark') {
				    $value = $template['name'];
			    }
			    $fields[] = [
				    'name' => $this->getAttributeLabel($key),
				    'value' => $value,
			    ];
		    }

		    // формируем письмо
		    $mailer = Yii::$app->mailer->compose($template['template'], ['fields' => $fields])
			    ->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			    ->setTo(preg_split('/\s*,\s*/', Yii::$app->params['adminEmail']))
			    ->setSubject($template['subject']);
		    // отправляем письмо
		    if ($mailer->send()) {
			    return true;
		    } else {
			    $this->addError('', 'Возникла ошибка на сервере при отправке сообщения');
		    }
	    }
	    return false;
    }
}
