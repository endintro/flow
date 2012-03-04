<style>
.form-actions{background:none;}
legend{margin-bottom:0;}
</style>

<form action="" method="post" class="form-horizontal">
	<fieldset>
		<legend>Create Flow</legend>
		<div class="control-group">
			<label for="input" class="control-label">Name</label>
			<div class="controls">
				<input type="text" name="name" class="input-large">
			</div>
		</div>
		<div class="control-group">
            <label for="textarea" class="control-label">Description</label>
            <div class="controls">
              <textarea rows="3" name="description" class="input-xlarge"></textarea>
            </div>
          </div>
		<div class="form-actions">
			<input class="btn btn-primary" type="submit" value="Submit" />
			<input class="btn" type="reset" value="Reset" />
		</div>
	</fieldset>
</form>