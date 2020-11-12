<?php
/**
 * ImageGenerator Joomla! Native Component
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item):

        $link2edit='index.php?option=com_imagegenerator&view=imageform&layout=edit&id='.$item->id;
        
?>
        

        <tr class="row<?php echo $i % 2; ?>">
                <td><a href="<?php echo $link2edit; ?>"><?php echo $item->id; ?></a></td>
                <td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                <td><a href="<?php echo $link2edit; ?>"><?php echo $item->profilename; ?></a></td>
                <td><?php echo $item->width; ?></td>
		<td><?php echo $item->height; ?></td>
		<td><?php
		
			$fileformats=['unknown','gif','jpg','png','pdf'];
		$i=(int)$item->fileformat;
		if($i==100)
			$i=4;
		echo $fileformats[$i];
		
		?></td>
               
        </tr>
<?php endforeach;


?>
