<?php $this->pageTitle = 'Flow - Home';?>
<style>
	.row{margin-top:20px;}
	#uname{text-align:right;}
	.form-actions{background:none;}
	legend{margin-bottom:0;}
	
	#new_flow_form{display:none;}
</style>



<div class="row">
	<div id="uname" class="span2 offset9"><?php echo 'Hello '.$user->name?></div>
	<div class="span1"><a href="<?php  echo Yii::app()->request->getBaseUrl(true).'/user/logout' ?>">Logout</a></div>	
</div>	

<div class="row">
	<div class="span6">
		<div class="row">
			<button id="new_flow" class="btn btn-info">Create A New Flow</button>	
		</div>
		<div class="row">
			<?php foreach ($flows as $flow){?>
				<a class="btn" href="<?php  echo Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow->id ?>"><?php echo $flow->name;?></a>	
			<?php 	}?>
		</div>
	</div>
	<div class="span6">
		<form id="new_flow_form" action="<?php  echo Yii::app()->request->getBaseUrl(true).'/flow/create' ?>" method="post" class="form-horizontal">
			<fieldset>
				<legend>Create a new Flow</legend>
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
	</div>
</div>


<script>
	$(document).ready(function(){
		$('#new_flow').click(function(){
				$('#new_flow_form').fadeIn();
			});
	})
	
</script>
