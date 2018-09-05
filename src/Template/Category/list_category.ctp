<?php
if (empty($category)) {
    echo "Data Empty !";
} else {
    foreach ($category as $value) {
        echo $value['category_name'] . count($value->posts) . '<br>';
    }
}
?>
