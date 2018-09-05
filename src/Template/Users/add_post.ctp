<div class="list-addpost-admin">
    <h2 class="title-dashborad">Thêm bài viết</h2>
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
    <!-- Form Edit Post -->
    <?= $this->Form->create('', ['id' => 'form-edit-post']);?>

    <div class="form-group">
        <?= $this->Form->input('post-title', ['label' => 'Tên bài viết', 'class' => 'form-control', 'id' => 'post-title']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post-slug', ['label' => 'Đường dẫn', 'class' => 'form-control', 'id' => 'post-slug']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post-description', ['label' => 'Mô tả ngắn', 'class' => 'form-control']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('Nội dung', ['type' => 'textarea', 'class' => 'ckeditor form-control', 'id' => 'post-content', 'name' => 'post-content'])?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post-image', ['label' => 'Ảnh đại diện', 'class' => 'form-control', 'type' => 'file']);?>
    </div>
    <div class="form-group">
        <select class="form-control" id="post-category-add" name="post-category-add">
            <?php 
            foreach ($categoryModel as $keyCategory => $valueCategory) {
                ?>
                <option value="<?= $valueCategory->id?>"><?= $valueCategory->category_name?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group col-md-12">
        <?= $this->Form->input('Thêm', ['class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'add-post'])?>
    </div>
    <?=$this->Form->end();?>

    <!-- End Form -->
</div>
