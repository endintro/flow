<style>
.row{margin-top:20px;}
.form-actions{background:none; border-top:none;}
legend{margin-bottom:0;}
#new_water{height:200px;}
#new_water_form{display:none;}
.form-horizontal .controls{margin-left:60px;}
.form-horizontal .form-actions{padding-left:60px;}
.input-xlarge{width:360px;}
</style>

<div class="row">
	<h1>Flow @ <?php echo $flow->name?></h1>
</div>

<div class="row">
	<div class="span6">
		<?php 
			if($waters){
				foreach (array_reverse($waters) as $water){
					echo '<div class="row">'.n2p($water->water)."</div>";
				}
			}else{
				echo '<div class="row">暂时没有条目,鼠标移至右侧空白处添加 <i class="icon-arrow-right"></i></div>';
			}
			
			?>
	</div>
	<div id="new_water" class="span6">
		<form id="new_water_form" action="" method="post" class="form-horizontal">
			<fieldset>
				<div class="control-group">
		            <label for="textarea" class="control-label"></label>
		            <div class="controls">
		              <textarea id="post" rows="7" name="water" class="input-xlarge"></textarea>
		            </div>
		          </div>
				<div class="form-actions">
					<input class="btn btn-primary" type="submit" value="Submit" />
				</div>
			</fieldset>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#new_water').hover(function(){
				$('#new_water_form').fadeIn();
			},function(){
				var v = trim($('#post').val()); 
				if(v == ""){
					$('#new_water_form').fadeOut();
				}
			});
	})
	
	function trim(str){
		return str.replace(/(^\s*)|(\s*$)/g, "");
	}
</script>

<?php 
	function n2p($textarea){
		$textarea = nl2br($textarea);
		$newarr = explode("<br />\r\n<br />\r\n",$textarea);
		$res = "";
		foreach($newarr as $str) {
			$res = $res."<p>".$str."</p>";
		}
		return $res;
	}
?>
