<style>
.row{margin-top:20px;}
legend{margin-bottom:0;}

#new_water{padding-top:15px; height:300px;}
#new_water_form{display:none;}
#new_water .form-horizontal .controls{margin-left:60px;}
#new_water .form-horizontal .form-actions{background:none; border-top:none;padding-left:60px;}
#new_water .input-xlarge{width:360px;}
#new_water .tags{width:270px}
#new_water #sub{margin-left:20px;}

.container .section{border-bottom: 1px dotted #AAAAAA;margin-top: 10px;margin-bottom: 10px;padding-top: 14px;padding-bottom: 14px;width: 448px;}
.container .section .article p{line-height:22px; margin:0 0 14px;}
.container .section .article blockquote{font-size:12px;}
.container .section .footer a{float:right; margin-left:10px; color:#376B6D;}
.container .section .footer a:hover{text-decoration:none; color:#E16B8C}
.container .section .footer .remove{display:none}
.container .section .footer .remove{opacity:0.7;}
.container .pagenav{margin:0 0 30px -20px;}
.container .pagenav a{color:#376B6D;}
.container .pagenav a:hover{text-decoration:none; color:#E16B8C}

#footer {background: none repeat scroll 0 0 #333333;bottom: 0;height: 16px;position: fixed;width: 100%;padding-top:4px;}
#footer a{display:block; float:right; margin-right:10px;}
</style>


<div class="row">
	<h1>Flow @ <?php echo $flow->name?></h1>
</div>

<div class="row">
	<div class="span6">
		<?php 
			if($waters){
				foreach ($waters as $water){
					echo '<div class="row section"><div class="article">'.n2p($water->water).'</div><div class="footer">';
					if(isset($water_tags[$water->id])){
						foreach ($water_tags[$water->id] as $tag){
							echo '<a href="#" >'.$tag->name.'</a>';
						}
					}
					if($is_owner){
						echo '<i class="icon-trash remove"></i>';
						echo '<input class="water_id" id="w'.$water->id.'" type="hidden" value="'.$water->id.'" />';
					}
					echo '</div></div>';
				}
				echo '<div class="row pagenav">'.$page_nav.'</div>';
			}else{
				if($is_owner)
					echo '<div class="row">暂时没有条目,鼠标移至右侧空白处添加 <i class="icon-arrow-right"></i></div>';
				else
					echo '<div class="row">暂时没有条目</div>';
			}
			
			?>
	</div>
	<?php if($is_owner){?>
	<div id="new_water" class="span6">
		<form id="new_water_form" action="" method="post" class="form-horizontal">
			<fieldset>
				<div class="control-group">
		            <label for="textarea" class="control-label"></label>
		            <div class="controls">
		              <textarea id="post" rows="13" name="water" class="input-xlarge"></textarea>
		            </div>
		        </div>
		        <div class="control-group">
		          	<div class="controls">
		              <input class="tags" type="text" name="tags" />
		              <input id="sub" class="btn btn-info" type="submit" value="Submit" />
		              <p class="help-block">Input some tags seperated by ","</p>
		            </div>
		        </div>
			</fieldset>
		</form>
	</div>
	<?php }?>
</div>


<div id="footer">
	<a href="<?php  echo Yii::app()->request->getBaseUrl(true) ?>"><i class="icon-home icon-white"></i></a>
	<a href="<?php  echo Yii::app()->request->getBaseUrl(true) ?>"><i class="icon-search icon-white"></i></a>
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

		//move footer outside container
		var footer = $("#footer").clone();
		$("#footer").remove();
		footer.appendTo("body");

		$("#footer a i").hover(function(){
			$(this).css("opacity","0.3");
		},function(){
			$(this).css("opacity","1");
		});

		$(".section").hover(function(){
				$(this).find('.remove').css("display","block");
			},function(){
				$(this).find('.remove').css("display","none")
		});

		$(".section i.remove").click(function(){
			var water_id = $(this).parent().find(".water_id").val();
			$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: '<?php  echo Yii::app()->request->getBaseUrl(true).'/flow/deletewater' ?>',
				  data: "water_id="+water_id,
				  success: function( res ) {
				    	console.log(res);
				    	if(res.success) $('#w'+res.water_id).parent().parent().remove();
				  }
			});
		});
	});
	
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
