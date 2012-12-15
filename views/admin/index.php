
	<section class="title">
		<h4><?php echo lang('spamalot:section:logs'); ?></h4>
	</section>

	<section class="item">
	<?php if( isset($logs) and ! empty($logs) ): ?>
		<table>
			<thead>
				<tr>
					<th><?php echo lang('spamalot:label_last_seen'); ?></th>
					<th><?php echo lang('spamalot:label_email'); ?></th>
					<th><?php echo lang('spamalot:label_ip'); ?></th>
					<th><?php echo lang('spamalot:label_reported'); ?></th>
					<th><?php echo lang('spamalot:label_attempts'); ?></th>
					<th><?php echo lang('spamalot:label_email_freq'); ?></th>
					<th><?php echo lang('spamalot:label_email_conf'); ?></th>
					<th><?php echo lang('spamalot:label_ip_freq'); ?></th>
					<th><?php echo lang('spamalot:label_ip_conf'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="9"><!-- TODO: Add Pagination --></td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach( $logs as $log ): ?>
				<tr>
					<td><?php echo date('h:i d.m.Y', $log['last_seen']); ?></td>
					<td><?php echo $log['email']; ?></td>
					<td><?php echo $log['ip']; ?></td>
					<td><?php echo $log['reported']; ?></td>
					<td><?php echo $log['attempts']; ?></td>
					<td><?php echo $log['email_freq']; ?></td>
					<td><?php echo $log['email_conf']; ?>%</td>
					<td><?php echo $log['ip_conf']; ?></td>
					<td><?php echo $log['ip_conf']; ?>%</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="no_data"><?php echo lang('spamalot:label_no_logs'); ?></div>
	<?php endif; ?>
	</section>
