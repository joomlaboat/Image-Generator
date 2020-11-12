<?php
/**
 * ImageGenerator Joomla! Native Component
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$document = JFactory::getDocument();
$document->addCustomTag('<script src="components/com_imagegenerator/views/imageform/tmpl/jscolor.js"></script>');


jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;



?>

<style>
	.iginputbox{
		width:95% !important;
	}
</style>

<?php if($JoomlaVersionRelease>=3.0): ?>
	<form id="adminForm" action="<?php echo JRoute::_('index.php?option=com_imagegenerator'); ?>" method="post" class="form-inline">
<?php else: ?>
	<form action="<?php echo JRoute::_('index.php?option=com_imagegenerator&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="youtubegallery-form" class="form-validate">
<?php endif; ?>

        <fieldset class="adminform">
                <?php echo $this->form->getInput('id'); ?>
                
                        <table style="border:none;width:100%;">
                                <tbody>
					
					<tr><td style="width:150px;"><?php echo $this->form->getLabel('profilename'); ?></td><td>:</td><td><?php echo $this->form->getInput('profilename'); ?></td></tr>
					
					<tr><td><?php echo $this->form->getLabel('width'); ?></td><td>:</td><td><?php echo $this->form->getInput('width'); ?></td></tr>
					<tr><td><?php echo $this->form->getLabel('height'); ?></td><td>:</td><td><?php echo $this->form->getInput('height'); ?></td></tr>
					<tr><td><?php echo $this->form->getLabel('background'); ?></td><td>:</td><td><?php echo $this->form->getInput('background'); ?></td></tr>
					<tr><td><?php echo $this->form->getLabel('fileformat'); ?></td><td>:</td><td><?php echo $this->form->getInput('fileformat'); ?></td></tr>
					<tr><td><?php echo $this->form->getLabel('fileformatparam'); ?></td><td>:</td><td><?php echo $this->form->getInput('fileformatparam'); ?></td></tr>
					<tr><td><?php echo $this->form->getLabel('outputfilename'); ?></td><td>:</td><td><?php echo $this->form->getInput('outputfilename'); ?></td></tr>
					
					<tr><td><?php echo $this->form->getLabel('options'); ?></td><td>:</td><td><?php echo $this->form->getInput('options'); ?></td></tr>
					
                                </tbody>
                        </table>
                
			

        </fieldset>
        <div>
		<?php if($JoomlaVersionRelease>=3.0): ?>
			<input type="hidden" name="jform[id]" value="<?php echo (int)$this->item->id; ?>" />				
                <?php endif; ?>
		<input type="hidden" name="task" value="imageform.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>