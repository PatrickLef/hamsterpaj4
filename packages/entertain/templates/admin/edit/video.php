<h3>Datatyp: Video</h3>
<ul>
	<?php if(file_exists('/mnt/static/entertain/video/' . $item->handle . '.flv')): ?>
	<li>
		<input type="radio" name="video_action" value="noaction" id="video_noaction" checked="true" />
		<label for="video_noaction">Behåll aktuell videofil</label>
	</li>
	<?php endif; ?>
	<li>
		<input type="radio" name="video_action" value="upload" id="video_upload" />
		<label for="video_upload">Ladda upp ny videofil</label>
		<!-- <<input type="file" name="video_upload" /> --> Under utveckling
	</li>
	<li>
		<input type="radio" name="video_action" value="wget" id="video_wget" />
		<label for="video_wget">Hämta videofil från webben</label>
		<!-- <input type="text" name="video_url" /> --> Under utveckling
	</li>
	<li>
		<input type="radio" name="video_action" value="youtube" id="video_youtube" />
		<label for="video_youtube">Hämta videofil från Youtube.com (URL till filmklippet)</label>
		<input type="text" name="youtube_url" />
	</li>
</ul>
	
