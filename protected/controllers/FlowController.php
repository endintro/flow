<?php
define("PAGESIZE",50);

class FlowController extends CController
{
	private $_model;
	private $is_login = false;
	private $user;
	
	public function filters()
	{
		return array(
			'authFilter',
		);
	}
 
	public function FilterAuthFilter($filterChain) {
		$cookie = Yii::app()->request->getCookies();
		if(isset($cookie['auth'])){
			$user_exists = User::model()->findByAttributes(array('auth'=>$cookie['auth']->value));	
			if($user_exists){
				$this->is_login = true;
				$this->user = $user_exists;
			}
		}
		$filterChain->run();
	}
	
	
	public function actionIndex()
	{
		if($this->is_login){
			$request = Yii::app()->getRequest();
			if($request->getParam("f")){
				$flow_id = $request->getParam("f");
				$flow = Flow::model()->findByPk($flow_id);
				if($flow){
					//fetch data
					$waters = self::findWatersByPage($flow_id);
					$water_tags = self::getWaterTags($waters);
					$page_nav = self::pageNav($flow_id);
					
					$is_owner = false;
					if($flow->user_id == $this->user->id){
					 	//save data
						if($request->isPostRequest) self::saveWater($request,$flow_id);
						$is_owner = true;
					 }
					$this->render("index",
								array("flow"=>$flow,
								"waters"=>$waters,
								"water_tags"=>$water_tags,
								"page_nav"=>$page_nav,
								"is_owner"=>$is_owner)
					);
				}else $this->redirect(Yii::app()->request->getBaseUrl(true));	
			}else $this->redirect(Yii::app()->request->getBaseUrl(true));	
		}else $this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	public function actionCreate()
	{
		if($this->is_login){
			$request = Yii::app()->getRequest();
			if($request->isPostRequest){
				$name = $request->getPost("name");
				$description = $request->getPost("description");
				if($name && $description){
					$model=new Flow;
					$model->user_id = $this->user->id;
					$model->name = $name;
					$model->description = $description;
					$model->is_actived = 1;
					$model->create_time = date("Y-m-d H:i:s");
					if($model->save()){
						$this->redirect(Yii::app()->request->getBaseUrl(true).'/flow/?f='.$model->id);
					}
				}
			}
		}else
			$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	/*---------------------page start---------------------------*/
	protected function findWatersByPage($flow_id){	
		$PageSize = PAGESIZE;
		$PageCount = self::pageCount($flow_id);
		$page = 1;
		if(Yii::app()->getRequest()->getParam("page")) $page = intval(Yii::app()->getRequest()->getParam("page"));	
	 	if($page>$PageCount|$page==0) $page = 1;
    	
       	$sql = "select * from water where flow_id = '$flow_id' and is_display = 1 order by create_time desc limit ".($page-1)*($PageSize).",$PageSize";
        $waters = Water::model()->findAllBySql($sql);
        return $waters;
	}
	
	protected function pageCount($flow_id){
		$sql = "select count(*) as num from water where flow_id = '$flow_id' and is_display = 1 ";
		$res = Yii::app()->db->createCommand($sql)->queryRow();
		$waters_num = $res["num"];
		$PageSize = PAGESIZE;
		$PageCount = ceil($waters_num/$PageSize);
		return $PageCount;
	}
	
	protected function pageNav($flow_id){
		$PageSize = PAGESIZE;
		$PageCount = self::pageCount($flow_id);
		$page = 1;
		if(Yii::app()->getRequest()->getParam("page")) $page = intval(Yii::app()->getRequest()->getParam("page"));	
	 	if($page>$PageCount|$page==0) $page = 1;
	 	if($page == 1) return '<a href="'.Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id.'&page='.($page+1).'">下一页 »</a>';
	 	if($page == $PageCount) return '<a href="'.Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id.'&page='.($page-1).'">« 上一页</a>';
	 	return '<a href="'.Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id.'&page='.($page-1).'">« 上一页</a> | <a href="'.Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id.'&page='.($page+1).'">下一页 »</a>';
	}
	/*---------------------page end---------------------------*/
	
	/*---------------------save new water start---------------------------*/
	protected function saveWater($request,$flow_id){
		$water = trim($request->getPost("water"));
		if(!empty($water)){
			$model=new Water;
			$model->user_id = $this->user->id;
			$model->flow_id = $flow_id;
			$model->water 	= $water;
			$model->create_time = date("Y-m-d H:i:s");
			if($model->save()){
				self::saveTags($request, $model->id);
				$this->redirect(Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id);
			}
		}
	}
	
	protected function saveTags($request,$water_id){
		$tags = trim($request->getPost("tags"));
		if(!empty($tags)){
			$tag_arr = explode(",",$tags);
			foreach ($tag_arr as $tag){
				$tag = trim($tag);
				if(!empty($tag)){
					$is_exist = Tag::model()->findByAttributes(array('name'=>$tag));
					if($is_exist){ 
						self::saveRelWaterTag($water_id, $is_exist->id);
					}else{
						$model=new Tag;
						$model->name = $tag;
						if($model->save()) self::saveRelWaterTag($water_id, $model->id);
					}
				}
			}
		}
	}
	
	protected function saveRelWaterTag($water_id,$tag_id){
		$model=new RelWaterTag;
		$model->water_id = $water_id;
		$model->tag_id = $tag_id;
		$model->save();
	}
	/*---------------------save new water end---------------------------*/
	
	protected function getWaterTags($waters){
		$water_tag = array();
		foreach ($waters as $water){
			$rel_arr = RelWaterTag::model()->findAllByAttributes(array('water_id'=>$water->id));
			if(!empty($rel_arr)){
				foreach ($rel_arr as $rel){
					$water_tag[$water->id][] = Tag::model()->findByAttributes(array('id'=>$rel->tag_id));
				}
			}
		}
		if(empty($water_tag)) return NULL;
		return $water_tag;
	}
	
	public function actionDeletewater()
	{
		$res = array("success"=>false,"water_id"=>"");
		if($this->is_login){
			$request = Yii::app()->getRequest();
			if($request->isPostRequest){
				$water_id = $request->getPost("water_id");
				if(is_numeric($water_id)){
					$water = Water::model()->findByPk($water_id);
					$flow = Flow::model()->findByPk($water->flow_id);
					if($water && $flow && $flow->user_id==$this->user->id){
						$water->is_display = 0;
						$water->save();
						$res["success"] = true;
						$res["water_id"] = $water_id;
					}
				}
			}
		}
		echo json_encode($res);
	}
}