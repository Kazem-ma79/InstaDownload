<?php
require_once "func.php";
$input = file_get_contents('php://input');
if($input === '')
	die(json_encode(["status" => "failed"]));
$input = json_decode($input);
//$media_id = parseID($argv[1]);
$media_id = parseID($input->media_id);
$url = "https://www.instagram.com/p/$media_id/?__a=1";
if ($source = @file_get_contents($url)) {
	$data = json_decode($source, True);
	$data = $data["graphql"]["shortcode_media"];
	if (!array_key_exists("edge_sidecar_to_children", $data)) { //single
		$mode = "single";
		$tmp = array();
		if($data["is_video"] === true) { //video
			$tmp["type"] = "video";
			$tmp["url"] = $data["video_url"];
			$tmp["thumb"] = $data["display_url"];
		}
		else { //photo
			$tmp["type"] = "photo";
			$tmp["url"] = $edge["display_url"];
		}
		$datas = $tmp;
	}
	else { //album
		$mode = "multiple";
		$edges = $data["edge_sidecar_to_children"]["edges"];
		$datas = array();
		foreach($edges as $edge) {
			$tmp = array();
			$edge = $edge["node"];
			if($edge["is_video"] === true) { //video
				$tmp["type"] = "video";
				$tmp["url"] = $edge["video_url"];
				$tmp["thumb"] = $edge["display_url"];
			}
			else { //photo
				$tmp["type"] = "photo";
				$tmp["url"] = $edge["display_url"];
			}
			$datas[] = $tmp;
		}
	}
	$data = $datas;
	die(json_encode(["status" => "success", "data" => ["mode" => $mode, "posts" => $data]]));
}
else {
	die(json_encode(["status" => "failed"]));
}
