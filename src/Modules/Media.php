<?php

namespace Dxw\WordPressSetup\Modules;

class Media
{
	// Very much based on https://wordpress.stackexchange.com/questions/256830/programmatically-adding-images-to-media-library
	public function upload($pathOrUrl)
	{
		$uploadDir = wp_upload_dir();

		$imageData = file_get_contents($pathOrUrl);

		$filename = basename($pathOrUrl);

		if (wp_mkdir_p($uploadDir['path'])) {
			$file = $uploadDir['path'] . '/' . $filename;
		} else {
			$file = $uploadDir['basedir'] . '/' . $filename;
		}

		file_put_contents($file, $imageData);

		$wpFiletype = wp_check_filetype($filename, null);

		$attachment = [
			'post_mime_type' => $wpFiletype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		];

		$attachId = wp_insert_attachment($attachment, $file);
		$attachData = wp_generate_attachment_metadata($attachId, $file);
		wp_update_attachment_metadata($attachId, $attachData);
		return $attachId;
	}
}
