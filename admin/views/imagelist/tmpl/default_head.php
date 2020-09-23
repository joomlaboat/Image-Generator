<?php
/**
 * ImageGenerator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;


?>
<tr>
        <th width="5">
                <?php echo JText::_('COM_IMAGEGENERATOR_ID'); ?>
        </th>
        <th width="20">
                <?php if($JoomlaVersionRelease>=3.0): ?>
                        <input type="checkbox" name="checkall-toggle" value="" title="Check All" onclick="Joomla.checkAll(this)" />
                <?php else: ?>
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
		<?php endif; ?>
        </th>                     
        <th align="left" style="text-align:left;"><?php echo JText::_('COM_IMAGEGENERATOR_FIELD_NAME_LABEL'); ?></th>
	<th align="left" style="text-align:left;"><?php echo JText::_('COM_IMAGEGENERATOR_FIELD_WIDTH_LABEL'); ?></th>
	<th align="left" style="text-align:left;"><?php echo JText::_('COM_IMAGEGENERATOR_FIELD_HEIGHT_LABEL'); ?></th>
	<th align="left" style="text-align:left;"><?php echo JText::_('COM_IMAGEGENERATOR_FIELD_FILEFORMAT_LABEL'); ?></th>
		
</tr>

