<div class="content_menu">
	<ul>
		<li>
			<label for="entertain_sort_view">Vy:</label>
			<select id="entertain_sort_view">
				<option <?php echo $view == 'thumbnails'? 'selected="selected"' : NULL; ?> value="thumbnails">Thumbnaglar</option>
				<option <?php echo $view == 'list'? 'selected="selected"' : NULL; ?> value="list">Lista</option>
				<option <?php echo $view == 'group'? 'selected="selected"' : NULL; ?> value="group">Grupperad</option>
			</select>
		</li>	
		<li>
			<label for="entertain_sort_order_by">Ordna efter:</label>
			<select id="entertain_sort_order_by">
			<!--	<option>Kommentarer</option> -->
				<option <?php echo $order_by == 'views'? 'selected="selected"' : NULL; ?> value="views">Visningar</option>	
				<option <?php echo $order_by == 'date'? 'selected="selected"' : NULL; ?> value="date">Datum</option>
				<option <?php echo $order_by == 'alphabetical'? 'selected="selected"' : NULL; ?> value="alphabetical">Bokstavsordning</option>	
			<!--	<option>Populäraste</option> -->	
			</select>
		</li>
		<li>	
			<label for="entertain_sort_released_within">Publicerat:</label>
			<select id="entertain_sort_released_within">
				<option <?php echo $released_within == 'all_time'? 'selected="selected"' : NULL; ?> value="all_time">Sedan urminnes tider</option>
				<option <?php echo $released_within == 'one_day'? 'selected="selected"' : NULL; ?> value="one_day">Inom en dag</option>
				<option <?php echo $released_within == 'one_week'? 'selected="selected"' : NULL; ?> value="one_week">Senaste veckan</option>
				<option <?php echo $released_within == 'one_month'? 'selected="selected"' : NULL; ?> value="one_month">Senaste månaden</option>
				<option <?php echo $released_within == 'one_year'? 'selected="selected"' : NULL; ?> value="one_year">Senaste året</option>
			</select>
		</li>
	</ul>
</div>