<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\libs\Html;
use humhub\modules\content\widgets\richtext\RichText;
use humhub\modules\space\models\Space;
use humhub\modules\space\widgets\Image;
use humhub\modules\space\widgets\SpaceDirectoryActionButtons;
use humhub\modules\space\widgets\SpaceDirectoryIcons;
use humhub\modules\space\widgets\SpaceDirectoryStatus;
use humhub\modules\space\widgets\SpaceDirectoryTagList;
use yii\web\View;

/* @var $this View */
/* @var $space Space */
?>

<div class="card-panel<?php if ($space->isArchived()) : ?> card-archived<?php endif; ?>">
    <div class="card-bg-image"<?php if ($space->getProfileBannerImage()->hasImage()) : ?> style="background-image: url('<?= $space->getProfileBannerImage()->getUrl() ?>')"<?php endif; ?>></div>
    <div class="card-header">
        <?= Image::widget([
            'space' => $space,
            'link' => true,
            'linkOptions' => ['data-contentcontainer-id' => $space->contentcontainer_id, 'class' => 'card-image-link'],
            'width' => 94,
        ]); ?>
        <?= SpaceDirectoryStatus::widget(['space' => $space]); ?>
        <div class="card-icons">
            <?= SpaceDirectoryIcons::widget(['space' => $space]); ?>
        </div>
    </div>
    <div class="card-body">
        <strong class="card-title"><?= Html::containerLink($space); ?></strong>
        <?php if (trim($space->description) !== '') : ?>
            <div class="card-details"><?= Html::encode($space->description); ?></div>
        <?php endif; ?>
	    <?php if (trim($space->about) !== '') : ?>
            <div>
                <div data-ui-markdown data-ui-show-more data-collapse-at="600">
				    <?= RichText::output($space->about) ?>
                </div>
            </div>
	    <?php endif; ?>
        <?= SpaceDirectoryTagList::widget([
            'space' => $space,
            'template' => '<div class="card-tags">{tags}</div>',
        ]); ?>
    </div>
    <?= SpaceDirectoryActionButtons::widget([
        'space' => $space,
        'template' => '<div class="card-footer">{buttons}</div>',
    ]); ?>
</div>