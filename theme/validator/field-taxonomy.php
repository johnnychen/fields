<table class="table table-bordered">
<!--
	<tr>
		<th>筛选</th>
		<td>items</td>
	</tr>
	<tr>
		<td>分类</td>
		<td>
		<?php
		// $terms = get_terms('field_category', 'pad_counts=1');
		// foreach ( $terms as $term ) {
			// echo '<a href="' . get_term_link( $term->slug, 'field_category') . '">' . $term->name . '</a>('.$term->count.') ,';
		// }
		?>
		</td>
	</tr>-->
	<tr>
		<td>字段类型</td>
		<td>
		<?php
		$terms = get_terms('field_type', 'pad_counts=1');
		foreach ( $terms as $term ) {
			echo '<a href="' . get_term_link( $term->slug, 'field_type') . '">' . $term->name . '</a>('.$term->count.') ,';
		}
		?>
		</td>
	</tr>

	<tr>
		<td>字段标签</td>
		<td>
		<?php
		$terms = get_terms('field_tag', 'pad_counts=1');
		foreach ( $terms as $term ) {
			echo '<a href="' . get_term_link( $term->slug, 'field_tag') . '">' . $term->name . '</a>('.$term->count.') ,';
		}
		?>
		</td>
	</tr>
</table>