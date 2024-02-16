
<thead>
	<tr>
		<th>Name</th>
		<th>Description</th>
	</tr>
</thead>
<tbody>
<?php  foreach($topics as $topic){ 
?>
	<tr>
		<td>
			<p><?php echo $topic['topic_name']; ?></p>
		</td>
		
		<td>
			<p><?php echo $topic['topic_des']; ?></p>
		</td>
		
	</tr>
<?php 
} 
?>
</tbody>
                    