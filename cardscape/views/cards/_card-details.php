<?php
$image = (Yii::app()->baseUrl . '/images/default-no-image.png');
if ($card->image) {
    $image = (Yii::app()->baseUrl . '/' . Yii::app()->params['cardscapeDataDir'] . '/' . $card->image);
}
?>

<div class="card-detais">
    <div class="card-image">
        <img src="<?php echo $image; ?>" />
    </div>

    <table class="card-data">
        <tbody>
            <?php foreach ($attributes as $attribute) { ?>
                <tr>
                    <td><?php echo $attribute->name; ?></td>
                    <td><?php echo $attribute->value; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="clear"></div>
</div>
