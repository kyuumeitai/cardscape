<?php
$imageRowSpan = 1 + count($attributes);

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
        </tr>

        <?php foreach ($attributes as $attribute) { ?>
            <tr>
                <td><?php echo $attribute->name; ?></td>
                <td><?php echo $attribute->value; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>