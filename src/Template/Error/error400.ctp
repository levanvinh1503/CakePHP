<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';
?>
<h2 class="title-error">404</h2>
<p class="content-error">
    <?= __d('cake', 'Trang {0} không tồn tại.', "<strong>'{$url}'</strong>") ?>
</p>
