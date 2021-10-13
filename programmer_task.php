<?php

$json_tree = file_get_contents('tree.json');
$json_list = file_get_contents('list.json');

$arr_tree = json_decode($json_tree, true);
$arr_list = json_decode($json_list, true);

function searchByValue(array &$arr, int $searchkey, string $name): void
{
  foreach ($arr as &$val) {
    if (is_array($val)) {
        searchByValue($val, $searchkey, $name);
    } else {
      if ($searchkey == $val) {
        $arr['name'] = $name;
      }
    }
  }
  return;
}

function mergeName(array $list, array $tree): array 
{
  foreach($list as $elem) {
      searchByValue($tree, $elem['category_id'], $elem['name']);
  }
  
  return $tree;
}

function output(array $tree): string
{
  return json_encode($tree);
}

$tree = mergeName($arr_list, $arr_tree);

print output($tree);