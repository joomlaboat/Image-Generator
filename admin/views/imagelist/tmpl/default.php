<?php
/**
 * ImageGenerator Joomla! 3.0 Native Component
 * @version 1.0.0
 * @author Ivan Komlev< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

		
?>

<form action="<?php echo JRoute::_('index.php?option=com_imagegenerator'); ?>" method="post" name="adminForm" id="adminForm">

<?php if($JoomlaVersionRelease>=3.0):
	//for joomla 3.0
	$s=JRequest::getVar( 'search');
?>
<div id="j-main-container" class="span10">
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="search" class="element-invisible">Search title.</label>
				<input type="text" name="search" placeholder="Search title." id="search" value="<?php echo $s; ?>" title="Search title." />
			</div>
			<div class="btn-group pull-left hidden-phone">
				<button class="btn tip hasTooltip" type="submit" title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('search').value='';this.form.submit();" title="Clear"><i class="icon-remove"></i></button>
			</div>
			
			
</div></div>

		<div class="clearfix"> </div>
		

        <table class="table table-striped">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
<?php else:
	// for joomla 2.5
?>
	
		
				<?php echo JText::_( 'COM_IMAGEGENERATOR_FILTER' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				
		
	</table>

        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>

<?php endif; ?>

		<input type="hidden" id="task" name="task" value="" />
                <input type="hidden" id="boxchecked" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
</form>

