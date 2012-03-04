<style>
.form-actions{background:none;}
legend{margin-bottom:0;}
</style>

<form action="" method="post" class="form-horizontal">
	<fieldset>
		<legend>Create Water</legend>
		<div class="control-group">
            <label for="textarea" class="control-label">Description</label>
            <div class="controls">
              <textarea rows="3" name="water" class="input-xlarge"></textarea>
            </div>
          </div>
		<div class="form-actions">
			<input class="btn btn-primary" type="submit" value="Submit" />
		</div>
	</fieldset>
</form>

<?php 
if($waters){
	foreach ($waters as $water){
		echo "<p>".$water->water."</p>";
	}
}

?>