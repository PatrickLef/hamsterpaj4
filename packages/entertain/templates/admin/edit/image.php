<h3>Datatyp: Bild</h3>
<ul style="list-style: none; padding: 0; line-height: 2.5;">
	<?php if(file_exists('/mnt/static/entertain/images/' . $item->handle . '.jpg')): ?>
	<li>
		<input type="radio" name="image_action" value="noaction" id="image_noaction" checked="true" />
		<label for="image_noaction">Behåll aktuell bild</label>
	</li>
	<?php endif; ?>
	<li>
		<input type="radio" name="image_action" value="upload" id="image_upload" />
		<label style="display: inline-block; width: 175px;" for="image_upload">Ladda upp ny bild</label>
		<input type="file" name="image_upload" />
	</li>
	<li>
		<input type="radio" name="image_action" value="wget" id="image_wget" />
		<label style="display: inline-block; width: 175px;" for="image_wget">Hämta bild från webben</label>
		<input type="text" name="image_url" />
	</li>
</ul>
	