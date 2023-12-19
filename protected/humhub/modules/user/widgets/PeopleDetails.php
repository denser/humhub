<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\widgets;

use humhub\components\Widget;
use humhub\modules\user\models\ProfileField;
use humhub\modules\user\models\User;
use yii\helpers\StringHelper;

/**
 * PeopleDetails shows details for back side of the people card
 *
 * @since 1.9
 * @author Luke
 */
class PeopleDetails extends Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var string Separator between lines
     */
    public $separator = '<br>';

    /**
     * @var string Template for lines
     */
    public $template = '{lines}';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $lines = [];

        for ($i = 1; $i <= 10; $i++) {
	        $profileField = $this->getProfileFieldValue(PeopleCard::config('detail' . $i));
        	//var_dump($profileField);
	        if ($profileField &&
		        !in_array($profileField, ['<a href="tel://" />',"",'<a href="mailto:" />']) &&
		        !stristr($profileField, '<a href="/people')) {
            	$lines[] = "<span id='detail$i'>$profileField</span>";
            }
        }

        if (empty($lines)) {
            return '';
        }

        return str_replace('{lines}', implode($this->separator, $lines), $this->template);
    }

    /**
     * Get user profile field value by internal name
     *
     * @param string $internalName
     * @return false|string
     */
    private function getProfileFieldValue(string $internalName)
    {
        if (empty($internalName)) {
            return false;
        }

        static $profileFields;

        if (!is_array($profileFields)) {
            $profileFields = [];
        }

        if (!array_key_exists($internalName, $profileFields)) {
            $profileFields[$internalName] = ProfileField::find()
                ->where(['visible' => 1])
                ->andWhere(['internal_name' => $internalName])
                ->one();
        }

        if (!$profileFields[$internalName]) {
            return false;
        }

        return StringHelper::truncate($profileFields[$internalName]->getUserValue($this->user, false), 200, '...', null, true);
    }

}
