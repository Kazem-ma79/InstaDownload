<?php
function parseID($media_id) {
	$media_id = remove($media_id, 'https://');
	$media_id = remove($media_id, 'http://');
	$media_id = remove($media_id, 'www.');
	$media_id = remove($media_id, 'instagram.com/p/');
	$media_id = endAfter($media_id, '/');
	return $media_id;
}
function remove($input, $search) {
	return str_replace($search, '', $input);
}
function endAfter($input, $search) {
	return substr($input, 0, strpos($input, $search));
}