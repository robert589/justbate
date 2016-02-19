<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PersonalizedChoiceForm extends Model
{
    public $choice_one;

    public $choice_two;

    public $choice_three;

    public $choice_four;

    public $choice_five;

    public $choice_six;

    public $choice_seven;

    public $choice_eight;

    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
        [
            ['choice_one', 'choice_two', 'choice_three', 'choice_four',
            'choice_five', 'choice_six','choice_seven', 'choice_eight'],
            'unique',
            'targetAttribute' => ['choice_one', 'choice_two', 'choice_three', 'choice_four', 'choice_five',
                                    'choice_six', 'choice_seven', 'choice_eight']
        ],

       [ ['choice_one', 'choice_two', 'choice_three', 'choice_four',
        'choice_five', 'choice_six','choice_seven', 'choice_eight'], 'string']
          ];

    }


}