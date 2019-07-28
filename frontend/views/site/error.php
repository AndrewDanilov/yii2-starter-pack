<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div style="width:500px;max-width:100%;margin:0 auto;padding:60px 20px;line-height:1.5em;min-height:70vh;">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
                Meanwhile, you may <a href='<?= Yii::$app->homeUrl ?>'>return to main page</a>
            </p>
        </div>
    </div>

</div>
