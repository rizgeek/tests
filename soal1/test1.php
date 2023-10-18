<?php

$json_data = file_get_contents("data.json");
$json_data = json_decode($json_data);


$result_tmp = [];


foreach ($json_data->custom as $data) {
	if($data->type === "parent") {

		$tmp_parent = (array) $data;
		$tmp_parent['data'] = [];

		$result_tmp[$data->id] = $tmp_parent;
	} else  {
		if($data->parent_id !== null) {
			$result_tmp[$data->parent_id]['data'][] = (array) $data;
			continue;
		}

		$result_tmp[$data->parent_id] = (array) $data;

	}
}

$result['custom'] = $result_tmp;
print_r($result);

die;