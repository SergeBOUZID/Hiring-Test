<?php 
/*
 * This template allows to build page list.
 * Include the list template.
 * 
 * Arguments :
 * -> $strRteNmListhow
 * -> ($strUrlListShow = '')
 * -> $strIdListContent
 * -> $strClassListCrit
 * -> $strIdListPageActiv
 * -> ($boolListIsPopup = false)
 * -> ($boolCriteriaBtHide = true)
 * -> ($strListScriptAfter = '')
 * -> $tabCrit['nm_col'] = array('type=text', 'label', 'value', 'input-add', 'max_size', 'size');
 * -> $tabCrit['nm_col'] = array('type=select', 'label', 'list');
 * -> $tabCrit['nm_col'] = array('type=checkbox', 'label', 'value', 'selected');
 * -> $tabCritBt[LibBt] = array('primary-info-success-warning-danger', 'script-action', 'glyphicon-...');
 * -> With arguments in the list template.
 */
?>



<?php // Init var ?>
<?php 
	$boolTabCrit = false;
	if(isset($tabCrit))
	{
		if(is_array($tabCrit))
		{
			if(count($tabCrit) > 0)
			{
				$boolTabCrit = true;
			}
		}
	}
	
	// Check is popup
	if(!isset($boolListIsPopup))
	{
		$boolListIsPopup = false;
	}
	
	$strListIsPopup = 'false';
	if($boolListIsPopup)
	{
		$strListIsPopup = 'true';
	}
	
	// Check set button hide criteria
	if(!isset($boolCriteriaBtHide))
	{
		$boolCriteriaBtHide = true;
	}
	
	// Set script if needs
	if(!isset($strListScriptAfter))
	{
		$strListScriptAfter = '';
	}
	
	$boolTabCritBt = false;
	if(isset($tabCritBt))
	{
		if(is_array($tabCritBt))
		{
			if(count($tabCritBt) > 0)
			{
				$boolTabCritBt = true;
			}
		}
	}
	
	// Set url list
	$strUrlList = '';
	if(isset($strUrlListShow))
	{
		if(trim($strUrlListShow) != '')
		{
			$strUrlList = $strUrlListShow;
		}
	}
	
	if(trim($strUrlList) == '')
	{
		$strUrlList = $this->getRouteUrl($strRteNmListhow);
	}
?>

<div class="container col-xs-12 col-sm-12 col-md-12 col-lg-12" >
	<?php // Criteria ?>
	<?php 
		if($boolTabCrit)
		{ 
	?>
		<?php // Criteria title ?>
		<div class="row wbs-frame-title">
			Criteria
		</div>
		
		
		
		<?php // Criteria content ?>
		<div class="row wbs-frame-content" >
			<?php 
				foreach($tabCrit as $key => $value)
				{
			?> 
				<div class="row form-group wbs-form-data">
					<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-11 col-sm-11 col-md-2 col-lg-2 col-xs-offset-1 col-sm-offset-1 col-md-offset-0 col-lg-offset-0">
							<label for="<?php echo($key); ?>" class="control-label input-sm"><?php echo($value[1]); ?></label>
						</div>
						<div class="col-xs-11 col-sm-11 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-0 col-lg-offset-0">
							<?php 
								if($value[0] == 'text')
								{
									$boolInputAdd = false;
									if(trim($value[3]) != '')
									{
										$boolInputAdd = true;
									}
							?> 
								<?php 
									if($boolInputAdd)
									{
								?> 
									<div class="input-group">
										<span class="input-group-addon"><?php echo($value[3]); ?></span>
								<?php } ?>
									<input type="<?php echo($value[0]); ?>" id="<?php echo($key); ?>" name="<?php echo($key); ?>" class="form-control input-sm <?php echo($strClassListCrit); ?>" value="<?php echo($value[2]); ?>" maxlength="<?php echo($value[4]); ?>">
								<?php 
									if($boolInputAdd)
									{
								?> 
									</div>
								<?php } ?>
							<?php 
								}
								else if($value[0] == 'select')
								{
							?> 
								<?php echo($value[2]); ?>
							<?php 
								}
								else if($value[0] == 'checkbox')
								{
							?> 
								<input type="checkbox" id="<?php echo($key); ?>" name="<?php echo($key); ?>" class="checkbox input-sm <?php echo($strClassListCrit); ?>" value="<?php echo($value[2]); ?>" <?php if(trim(strtolower($value[3])) == 'checked'){echo('checked="checked"');} ?> >
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			
			
			
			<?php // Form buttons ?>
			<div class="input-sm wbs-form-btn">
				<div class="pull-right hidden-xs" style="margin-bottom:10px;" >
					<?php 
						if(!array_key_exists('Show all', $tabCritBt))
						{
					?>
						<button 
							type="button"
							class="btn btn-primary btn-sm" 
							style="margin-right:5px;" 
							onclick="setListSearch(0, '<?php echo($strUrlList);?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', <?php echo($strListIsPopup);?>, '<?php echo($strListScriptAfter);?>');" 
						>
							<span class="glyphicon glyphicon-list-alt"></span> <?php echo('Show all'); ?>
						</button>
					<?php } ?>
					
					<?php 
						if(!array_key_exists('Search', $tabCritBt))
						{
					?>
						<button 
							type="button"
							class="btn btn-primary btn-sm" 
							style="margin-right:5px;" 
							onclick="setListSearch(1, '<?php echo($strUrlList);?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', <?php echo($strListIsPopup);?>, '<?php echo($strListScriptAfter);?>');" 
						>
							<span class="fa fa-binoculars"></span> <?php echo('Search'); ?>
						</button>
					<?php } ?>
					
					<?php 
						if($boolTabCritBt)
						{
							foreach($tabCritBt as $key => $value)
							{
								$strIco = '';
								if(trim($value[2]) != '')
								{
									$strIco = '<span class="'.$value[2].'"></span> ';
								}
					?>
						
						<button 
							type="button" 
							class="btn btn-<?php echo($value[0]); ?> btn-sm" 
							style="margin-right:5px;" 
							onclick="<?php echo($value[1]); ?>" 
						>
							<?php echo($strIco.$key); ?>
						</button>
					<?php 
							}
						}
					?>
				</div>
				
				<div class="col-xs-12 visible-xs">
					<?php 
						if(!array_key_exists('Show all', $tabCritBt))
						{
					?>
						<button 
							type="button"
							class="col-xs-12 btn btn-primary btn-md" 
							style="margin-bottom:5px;" 
							onclick="setListSearch(0, '<?php echo($strUrlList);?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', <?php echo($strListIsPopup);?>, '<?php echo($strListScriptAfter);?>');" 
						>
							<span class="glyphicon glyphicon-list-alt"></span> <?php echo('Show all'); ?>
						</button>
					<?php } ?>
					
					<?php 
						if(!array_key_exists('Search', $tabCritBt))
						{
					?>
						<button 
							type="button"
							class="col-xs-12 btn btn-primary btn-md" 
							style="margin-bottom:5px;" 
							onclick="setListSearch(1, '<?php echo($strUrlList);?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', <?php echo($strListIsPopup);?>, '<?php echo($strListScriptAfter);?>');" 
						>
							<span class="fa fa-binoculars"></span> <?php echo('Search'); ?>
						</button>
					<?php } ?>
					
					<?php 
						if($boolTabCritBt)
						{
							foreach($tabCritBt as $key => $value)
							{
								$strIco = '';
								if(trim($value[2]) != '')
								{
									$strIco = '<span class="'.$value[2].'"></span> ';
								}
					?>
						
						<button 
							type="button" 
							class="col-xs-12 btn btn-<?php echo($value[0]); ?> btn-md" 
							style="margin-bottom:5px;" 
							onclick="<?php echo($value[1]); ?>" 
						>
							<?php echo($strIco.$key); ?>
						</button> 
					<?php 
							}
						}
					?>
				</div>
			</div>
			
		</div>
	<?php } ?>
	
	
	<?php // List ?>
	<div id="<?php echo($strIdListContent);?>" style="width:100%;">
		<?php echo($strListView); ?>
	</div>
	
</div>