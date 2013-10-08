<table class="table table-bordered">
	<!--<tr>
		<th>筛选</th>
		<td>items</td>
	</tr>-->
	<tr>
		<td>类型</td>
		<td>
		<?php
		$terms = get_terms('rule_type', 'pad_counts=1');
		foreach ( $terms as $term ) {
			echo '<a href="' . get_term_link( $term->slug, 'rule_type') . '">' . $term->name . '</a>('.$term->count.') ,';
		}
		?>
		</td>
	</tr>
</table>