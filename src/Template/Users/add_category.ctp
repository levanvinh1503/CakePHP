<div class="list-addcategory-admin">
    <h2 class="title-dashborad">Thêm chuyên mục</h2>
    <?php
    $messageShow = $this->Flash->render();
    if ($messageShow) {
        ?>
        <div class="alert alert-success" onclick="this.classList.add('hidden')"><?= $messageShow?></div>
        <?php
    }
    if (!empty($errorsValidator)) {
        echo '<div class="alert alert-danger">';
        foreach ($errorsValidator as $keyError => $valueError) {
            foreach ($valueError as $keyItem => $valueItem) {
                echo $valueItem . '<br>';
            }
        }
        echo '</div>';
    }
    ?>
    <!-- Form add Category -->
    <?= $this->Form->create('', ['id' => 'form-add-category']);?>
    <div class="form-group">
        <?= $this->Form->input('category-name', ['label' => 'Tên chuyên mục', 'class' => 'form-control']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('category-slug', ['label' => 'Đường dẫn', 'class' => 'form-control']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('Chỉnh sửa', ['class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'edit-post']);?>
    </div>
    <!-- End Form add Category -->
</div>
