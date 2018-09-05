<?php
if (empty($posts)) {
    echo "Data Empty !";
} else {
    foreach ($posts as $value) {
        echo $value['post_title'] . '<br>';
        echo $value->category->category_name . '<br>';
    }
}
?>
