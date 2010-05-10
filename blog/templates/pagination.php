<div class="pagination">
	<?php if ($offset > 1): ?>
		<?php echo '&lArr; '.html_link('first', 'browse', '', '&page=1'); ?>
		&ensp;&larr;
		<?php echo html_link('prev', 'browse', '', '&page='.($offset-1)); ?>
		&ensp;|&ensp;
	<?php endif; ?>
	Page <?php echo $offset; ?> of <?php echo ceil($total/PAGE_LIMIT); ?>
	<?php if ($offset < ceil($total/PAGE_LIMIT)): ?>
		&ensp;|&ensp;
		<?php echo html_link('next', 'browse', '', '&page='.($offset+1)); ?>
		&rarr;&ensp;
		<?php echo html_link('last', 'browse', '', '&page='.ceil($total/PAGE_LIMIT)).' &rArr;'; ?>
	<?php endif; ?>
</div>