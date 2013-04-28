<?php
$attributeCount = count($attributes);
$imageRowSpan = ($attributeCount > 0 ? $attributeCount : 1);

$image = (Yii::app()->baseUrl . '/images/default-no-image.png');
if ($card->image) {
    $image = (Yii::app()->baseUrl . '/' . Yii::app()->params['cardscapeDataDir'] . '/' . $card->image);
}
?>
<div class="span-10 card-image">
    <img src="<?php echo $image; ?>" />
</div>
<div class="span-13 last">
    <table style="width: 100%; vertical-align: middle">
        <tbody>
            <?php foreach ($attributes as $attribute) { ?>
                <tr>
                    <td><?php echo $attribute->name; ?></td>
                    <td><?php echo $attribute->value; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>