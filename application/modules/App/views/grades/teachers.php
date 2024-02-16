<div class="table-responsive">
	<!-- Table -->
    <table class="table table-striped table-responsive" width="100%">
		<thead>
			<tr>
				<th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
			</tr>
		</thead>
        <tbody>
			<?php if (count($teachers) == 0) { ?>
				<tr>
					<td colspan="100%">Sorry!! No Records found.</td>
                </tr>
			<?php } ?>
            <?php foreach($teachers as $item) { ?>
				<tr>
					<td><input type="checkbox" name="item_id[<?php echo $item->id;?>]" class="checkbox-item" value="Y"></td>
                    <td><?php echo name_display($item->name, '', '');?></td>
                    <td><?php echo $item->email;?></td>
                    <td><?php echo $item->phone;?></td>
				</tr>
			<?php } ?>
		</tbody>
                        
	</table>
</div>