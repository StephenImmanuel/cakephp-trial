<div class="row-fluid">
	<div class="alert alert-info">
		<h3>Migration Form</h3>
	</div>
</div>
<?php
echo $this->Form->create('MigrationUpload', array('controller' => 'migration', 'action' => 'migrate', 'type' => 'file'));
echo $this->Form->input('file', array('label' => 'Upload migration File', 'type' => 'file'));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>