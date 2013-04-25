<?php
/**
 * @var ProjectsController $this
 * @var Project $project
 */
$this->title = Yii::t('cardscape', 'Update project');
?>

<h1 class="fancy"><?php echo Yii::t('cardscape', 'Update {name} project', array('{name}' => $project->name)); ?></h1>

<?php
echo $this->renderPartial('_form', array('project' => $project));