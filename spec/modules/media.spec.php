<?php

describe(\Dxw\WordPressSetup\Modules\Media::class, function () {
	beforeEach(function () {
		$this->media = new \Dxw\WordPressSetup\Modules\Media();
	});

	describe('->upload()', function () {
		context('the upload path can be created', function () {
			it('uploads the file, updates the metadata and returns the attachment ID', function () {
				$pathOrUrl = '/path/to/file/to/upload.jpg';
				allow('wp_upload_dir')->toBeCalled()->andReturn([
					'path' => '/path/to/wp-content/uploads/monthly/folder',
					'basedir' => '/path/to/wp-content/uploads/'
				]);
				allow('file_get_contents')->toBeCalled()->andReturn('some file content');
				expect('file_get_contents')->toBeCalled()->once()->with($pathOrUrl);
				allow('wp_mkdir_p')->toBeCalled()->andReturn(true);
				allow('file_put_contents')->toBeCalled();
				expect('file_put_contents')->toBeCalled()->once()->with('/path/to/wp-content/uploads/monthly/folder/upload.jpg', 'some file content');
				allow('wp_check_filetype')->toBeCalled()->andReturn(['type' => 'jpg']);
				expect('wp_check_filetype')->toBeCalled()->once()->with('upload.jpg', null);
				allow('sanitize_file_name')->toBeCalled()->andRun(function ($input) {
					return '_' . $input . '_';
				});
				allow('wp_insert_attachment')->toBeCalled()->andReturn(123);
				expect('wp_insert_attachment')->toBeCalled()->once()->with([
					'post_mime_type' => 'jpg',
					'post_title' => '_upload.jpg_',
					'post_content' => '',
					'post_status' => 'inherit'
				], '/path/to/wp-content/uploads/monthly/folder/upload.jpg');
				allow('wp_generate_attachment_metadata')->toBeCalled()->andReturn('attachment metadata');
				expect('wp_generate_attachment_metadata')->toBeCalled()->once()->with(123, '/path/to/wp-content/uploads/monthly/folder/upload.jpg');
				allow('wp_update_attachment_metadata')->toBeCalled();
				expect('wp_update_attachment_metadata')->toBeCalled()->once()->with(123, 'attachment metadata');

				$result = $this->media->upload($pathOrUrl);

				expect($result)->toEqual(123);
			});
		});

		context('the upload path cannot be created', function () {
			it('uploads the file to the root upload folder, updates the metadata and returns the attachment ID', function () {
				$pathOrUrl = '/path/to/file/to/upload.jpg';
				allow('wp_upload_dir')->toBeCalled()->andReturn([
					'path' => '/path/to/wp-content/uploads/monthly/folder',
					'basedir' => '/path/to/wp-content/uploads'
				]);
				allow('file_get_contents')->toBeCalled()->andReturn('some file content');
				expect('file_get_contents')->toBeCalled()->once()->with($pathOrUrl);
				allow('wp_mkdir_p')->toBeCalled()->andReturn(false);
				allow('file_put_contents')->toBeCalled();
				expect('file_put_contents')->toBeCalled()->once()->with('/path/to/wp-content/uploads/upload.jpg', 'some file content');
				allow('wp_check_filetype')->toBeCalled()->andReturn(['type' => 'jpg']);
				expect('wp_check_filetype')->toBeCalled()->once()->with('upload.jpg', null);
				allow('sanitize_file_name')->toBeCalled()->andRun(function ($input) {
					return '_' . $input . '_';
				});
				allow('wp_insert_attachment')->toBeCalled()->andReturn(123);
				expect('wp_insert_attachment')->toBeCalled()->once()->with([
					'post_mime_type' => 'jpg',
					'post_title' => '_upload.jpg_',
					'post_content' => '',
					'post_status' => 'inherit'
				], '/path/to/wp-content/uploads/upload.jpg');
				allow('wp_generate_attachment_metadata')->toBeCalled()->andReturn('attachment metadata');
				expect('wp_generate_attachment_metadata')->toBeCalled()->once()->with(123, '/path/to/wp-content/uploads/upload.jpg');
				allow('wp_update_attachment_metadata')->toBeCalled();
				expect('wp_update_attachment_metadata')->toBeCalled()->once()->with(123, 'attachment metadata');

				$result = $this->media->upload($pathOrUrl);

				expect($result)->toEqual(123);
			});
		});
	});
});
