<?php 
/*
 * This template allows to build list.
 * 
 * Arguments :
 * -> $strRteNmListhow
 * -> $strIdListContent
 * -> $strClassListCrit
 * -> $strIdListPageActiv
 * -> $strIdListPageCount
 * -> $strMsgListEmpty
 * -> $boolListNav
 * -> $intPageActive
 * -> $intPageCount
 * -> $intRowCount
 * -> $tabCol['nm_col'] = array('lib_col', 'class visible xs, sm, md, lg');
 * -> $tabData['nm_col']['index_row'] = value of column name and num row;
 */
?>



<?php // Init var ?>
<?php 
	if(!isset($boolListNav))
	{
		$boolListNav = true;
	}
	
	// Check columns
	$boolTabCol = false;
	if(isset($tabCol))
	{
		if(count($tabCol) > 0)
		{
			$boolTabCol = true;
		}
	}
	
	// Get first column
	$strColFirst = '';
	if($boolTabCol)
	{
		foreach($tabCol as $key => $value)
		{
			$strColFirst = $key;
			break;
		}
	}
	
	// Check table of info
	$boolTabData = false;
	if(isset($tabData[$strColFirst]))
	{
		if(count($tabData[$strColFirst]) > 0)
		{
			$boolTabData = true;
		}
	}
?>



<?php // Build list if it needs ?>
<?php 
	if($boolTabData && $boolTabCol)
	{
?> 
	<?php 
		$strListNav = '';
		
		if($boolListNav)
		{
	?> 
		<?php // Initial values ?>
		<input type="hidden" id="<?php echo($strIdListPageActiv);?>" name="page_active" value="<?php echo($intPageActive); ?>" />
		<input type="hidden" id="<?php echo($strIdListPageCount);?>" name="page_count" value="<?php echo($intPageCount); ?>" />
		
		<?php // Build list nav ?>
		<?php 
				ob_start();
		?>
		<div class="row" style="margin-top:20px;margin-bottom:15px;text-align:center;" >
			<?php if($intPageActive > 1){ ?>
				<div class="btn-group">
					<button 
						class="btn btn-default btn-sm" 
						style="color:#555;background-color:#eee;" 
						title="<?php echo('Start'); ?>" 
						onClick="setListMove(0, '<?php echo($this->getRouteUrl($strRteNmListhow));?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', '<?php echo($strIdListPageCount);?>');" 
					>
						<span class="glyphicon glyphicon-step-backward"></span>
					</button>
					
					<button 
						class="btn btn-default btn-sm" 
						style="color:#555;background-color:#eee;" 
						title="<?php echo('Before'); ?>" 
						onClick="setListMove(1, '<?php echo($this->getRouteUrl($strRteNmListhow));?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', '<?php echo($strIdListPageCount);?>');" 
					>
						<span class="glyphicon glyphicon-triangle-left"></span>
					</button>
				</div>
			<?php } ?>
			
			<span class="" style="font-weight:bold;font-size:0.8em;" >
				<?php 
					echo
					(
						'Page : '.
						$intPageActive.'/'.$intPageCount.' '.
						'Total : '.
						count($tabData[$strColFirst]).'/'.$intRowCount
					); 
				?>
			</span>
			
			<?php if($intPageActive < $intPageCount){ ?>
				<div class="btn-group">
					<button 
						class="btn btn-default btn-sm" 
						style="color:#555;background-color:#eee;" 
						title="<?php echo('After'); ?>" 
						onClick="setListMove(2, '<?php echo($this->getRouteUrl($strRteNmListhow));?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', '<?php echo($strIdListPageCount);?>');" 
					>
						<span class="glyphicon glyphicon-triangle-right"></span>
					</button>
					
					<button 
						class="btn btn-default btn-sm" 
						style="color:#555;background-color:#eee;" 
						title="<?php echo('Last'); ?>" 
						onClick="setListMove(3, '<?php echo($this->getRouteUrl($strRteNmListhow));?>', '<?php echo($strIdListContent);?>', '<?php echo($strClassListCrit);?>', '<?php echo($strIdListPageActiv);?>', '<?php echo($strIdListPageCount);?>');" 
					>
						<span class="glyphicon glyphicon-step-forward"></span>
					</button>
				</div>
			<?php } ?>
			
		</div>
		<?php 
				$strListNav = ob_get_clean();
		?>
	<?php } ?>
	
	
	
	<?php // List nav top ?>
	<?php 
		echo($strListNav);
	?>
	
	
	
	<?php // List content ?>
	<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table table-bordered table-stripedz table-condensed wbs-list-table">
		<?php // table head ?>
		<tr>
			<?php 
				foreach($tabCol as $key => $value)
				{
					$strLibCol = $value[0];
					$strVisible = '';
					if(trim($value[1]) != '')
					{
						$strVisible = $value[1];
					}
			?>
				<th class="<?php echo($strVisible); ?> wbs-list-table-th wbs-custom-class-list-table-th" ><?php echo($strLibCol); ?></th>
			<?php } ?>
		</tr>
		
		<?php // table content ?>
		<?php 
			for($cpt = 0; $cpt < count($tabData[$strColFirst]); $cpt++)
			{
		?> 
			<tr>
				<?php 
					foreach($tabCol as $key => $value)
					{
						$strNmCol = $key;
						$strVisible = '';
						if(trim($value[1]) != '')
						{
							$strVisible = $value[1];
						}
				?> 
					<td class="<?php echo($strVisible); ?> wbs-list-table-td wbs-custom-class-list-table-td" > <!--class="wbs-list-table-data"-->
						<?php echo($tabData[$key][$cpt]); ?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</table>



	<?php // List nav bottom ?>
	<?php 
		echo($strListNav);
	?>

<?php 
	}
	else
	{
?>
	<?php // Msg no content ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert-default wbs-form-msg-main-success" style="color:#555;background-color:#eee;padding:20px;text-align:center;">
		<span class="glyphicon glyphicon-eye-close"></span> <?php echo($strMsgListEmpty); ?>
	</div>
<?php } ?>