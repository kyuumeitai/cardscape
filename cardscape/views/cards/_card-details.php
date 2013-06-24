<?php
$imageRowSpan = 2 + count($attributes);

$image = (Yii::app()->baseUrl . '/images/default-no-image.png');
if ($card->image) {
    $image = (Yii::app()->baseUrl . '/' . Yii::app()->params['cardscapeDataDir'] . '/' . $card->image);
}
?>

<table class="card-detais">
    <tbody>
        <tr>
            <td rowspan="<?php echo $imageRowSpan; ?>"><img src="<?php echo $image; ?>" /></td>
            <td rowspan="<?php echo $imageRowSpan; ?>" class="spacer-column"></td>
            <td><?php echo Yii::t('cardscape', 'Name'); ?></td>
            <td></td>
        </tr>

        <?php foreach ($attributes as $attribute) { ?>
            <tr>
                <td><?php echo $attribute->name; ?></td>
                <td><?php echo $attribute->value; ?></td>
            </tr>
        <?php } ?>

        <tr>
            <td><?php echo Yii::t('cardscape', 'Description'); ?></td>
            <td></td>
        </tr>
    </tbody>
</table>