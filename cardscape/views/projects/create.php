<?php
/**
 * @var ProjectsController $this
 * @var Project $project
 */
$this->title = Yii::t('cardscape', 'Create project');
?>

<h1><?php echo Yii::t('cardscape', 'Create new project'); ?></h1>

<?php
echo $this->renderPartial('_form', array('project' => $project));
