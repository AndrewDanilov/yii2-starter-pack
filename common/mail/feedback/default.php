<?php

/** @var array $fields */

use yii\helpers\Html;

?>

Письмо с сайта:<br /><br />

<?php foreach ($fields as $field) { ?>
	<?php if ($field['value'] === 'on') { $field['value'] = 'Да'; } ?>
	<?php if (is_array($field['value'])) { ?>
		<?= Html::encode($field['name']) ?>: <b><?= Html::encode(implode(', ', $field['value'])) ?></b><br />
	<?php } else { ?>
		<?= Html::encode($field['name']) ?>: <b><?= Html::encode($field['value']) ?></b><br />
	<?php } ?>
<?php } ?>
