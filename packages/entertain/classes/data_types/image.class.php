<?php
	class EntertainImage extends Entertain
	{
		function render()
		{
			$imagesize = getimagesize('/mnt/static/entertain/images/' . $this->get('handle') . '.jpg');
			Tools::Debug($imagesize);
			$width = $imagesize[1] > 638 ? 638 : $imagesize[1];
			return template('entertain' , 'views/image.php', array('item' => $this, 'imagewidth' => $width));
		}
		
		
		function set_data($data)
		{
			$this->data['text'] = $data['text'];
			$this->data['allow_html'] = $data['allow_html'];
		}
		
		function update_data_from_post()
		{
			switch($_POST['image_action'])
			{
				case 'wget':
					$cmd = 'wget ' . escapeshellarg($_POST['image_url']) . ' -O /mnt/static/entertain/images/' . escapeshellarg($this->handle) . '.jpg';
					shell_exec($cmd);
					$imagesize = getimagesize('/mnt/static/entertain/images/' . escapeshellarg($this->handle) . '.jpg');
					if($imagesize[1] > 638)
					{
						$cmd = 'convert /mnt/static/entertain/images/' . escapeshellarg($this->handle) . '.jpg -resize "638x1024" ' . PATH_STATIC . 'entertain/images/' . escapeshellarg($this->handle) . '.jpg';
						system($cmd);
					}
				break;
				case 'upload':
					if(is_uploaded_file($_FILES['image_upload']['tmp_name']))
					{
						$imagesize = getimagesize($_FILES['image_upload']['tmp_name']);
						$resize = $imagesize[1] > 638 ? '-resize "638x1024"' : '';
						$cmd = 'convert ' . $_FILES['image_upload']['tmp_name'] . ' ' . $resize . ' ' . PATH_STATIC . 'entertain/images/' . escapeshellarg($this->handle) . '.jpg';
						system($cmd);
					}
				break;
			}
		}
		
		function render_edit_form()
		{
			return template('entertain', 'admin/edit/image.php', array('item' => $this, 'data' => $this->get('data')));
		}
	}
?>