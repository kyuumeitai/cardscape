<h2><?php echo ($faction->isNewRecord ? 'Create' : 'Edit'); ?> Faction</h2>

<?php
$this->renderPartial('_form', array('faction' => $faction));