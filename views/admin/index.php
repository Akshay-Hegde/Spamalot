
	<section class="title">
		<h4><?php echo lang('spamalot:section:logs'); ?></h4>
	</section>

	<section class="item">
	<?php if( isset($logs) and ! empty($logs) ): ?>
		<table>
			<thead>
				<tr>
					<th class="center"><?php echo lang('spamalot:label_first_seen'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_last_seen'); ?></th>
					<th><?php echo lang('spamalot:label_email'); ?></th>
					<th><?php echo lang('spamalot:label_ip'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_reported'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_attempts'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_email_freq'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_email_conf'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_ip_freq'); ?></th>
					<th class="center"><?php echo lang('spamalot:label_ip_conf'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10"><?php echo $pagination['links']; ?></td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach( $logs as $log ): ?>
				<tr>
					<td class="center"><?php echo date('h:i d.m.Y', $log['first_seen']); ?></td>
					<td class="center"><?php echo date('h:i d.m.Y', $log['last_seen']); ?></td>
					<td<?php echo ( $log['email_freq'] >= 250 ? ' class="toxic"' : '' ); ?>><?php echo $log['email']; ?></td>
					<td<?php echo ( $log['ip_freq'] >= 250 ? ' class="toxic"' : '' ); ?>><?php echo $log['ip']; ?></td>
					<td><center><div class="<?php echo ( (int)$log['reported'] == 1 ? 'tick' : 'cross' ); ?>"></div></center></td>
					<td class="center"><?php echo $log['attempts']; ?></td>
					<td class="center"><?php echo $log['email_freq']; ?></td>
					<td class="center"><?php echo $log['email_conf']; ?>%</td>
					<td class="center"><?php echo $log['ip_freq']; ?></td>
					<td class="center"><?php echo $log['ip_conf']; ?>%</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="no_data"><?php echo lang('spamalot:label_no_logs'); ?></div>
	<?php endif; ?>
	</section>
