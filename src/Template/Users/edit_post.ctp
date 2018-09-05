<div class="list-addpost-admin">
    <h2 class="title-dashborad">Sửa bài viết</h2>
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
    <div class="col-md-8">
        <div class="form-group">
            <?= $this->Form->input('post-title', ['label' => 'Tên bài viết', 'class' => 'form-control', 'value' => $editPost->post_title]);?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post-slug', ['label' => 'Đường dẫn', 'class' => 'form-control', 'value' => $editPost->post_slug]);?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post-description', ['label' => 'Mô tả ngắn', 'class' => 'form-control', 'value' => $editPost->post_description]);?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('Nội dung', ['type' => 'textarea', 'value' => $editPost->post_content, 'class' => 'ckeditor form-control', 'id' => 'post-content', 'name' => 'post-content'])?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ảnh đại diện</label>
            <?= $this->Form->input('old-post-image', ['class' => 'form-control', 'type' => 'hidden', 'value' => $editPost->post_image]);?>
            <?= $this->Html->image(''.$editPost->post_image.'', ['width' => '100%', 'style' => 'border: 1px solid #c0c0c0; padding: 5px'])?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post-image', ['label' => 'Đổi hình ảnh', 'class' => 'form-control', 'type' => 'file']);?>
        </div>
        <div class="form-group">
            <select class="form-control" id="post-category-update" name="post-category-update">
                <?php 
                foreach ($listCategory as $keyCategory => $valueCategory) {
                    ?>
                    <option <?php if($valueCategory->id == $editPost->category_id_fkey) {
                       echo 'selected';
                   } ?> value="<?= $valueCategory->id?>"><?= $valueCategory->category_name?></option>
                   <?php
                }
               ?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-12">
        <?= $this->Form->input('Chỉnh sửa', ['class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'edit-post'])?>
    </div>
    <?=$this->Form->end();?>
<!-- End Form -->
</div>
