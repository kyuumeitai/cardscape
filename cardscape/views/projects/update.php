<?php $this->title = 'Update Project'; ?>

<h1>Update Project "<?php echo $project->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('project' => $project)); ?>