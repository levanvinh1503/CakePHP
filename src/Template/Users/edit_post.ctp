<div class="list-addpost-admin">
    <h2 class="title-dashborad">Sửa bài viết</h2>
    <?= $this->Flash->render('edit-post');?>
    <!-- Form Edit Post -->
    <?= $this->Form->create('', array('id' => 'form-edit-post', 'type' => 'file'));?>
    <div class="col-md-8">
        <div class="form-group">
            <?= $this->Form->input('post_title', array('label' => 'Tên bài viết', 'class' => 'form-control', 'value' => $editPost->post_title));?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post_slug', array('label' => 'Đường dẫn', 'class' => 'form-control', 'value' => $editPost->post_slug));?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post_description', array('label' => 'Mô tả ngắn', 'class' => 'form-control', 'value' => $editPost->post_description));?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('Nội dung', array('type' => 'textarea', 'value' => $editPost->post_content, 'class' => 'ckeditor form-control', 'id' => 'post-content', 'name' => 'post_content'))?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ảnh đại diện</label>
            <?= $this->Form->input('post_image', array('class' => 'form-control', 'type' => 'hidden', 'value' => $editPost->post_image));?>
            <?= $this->Html->image(''.$editPost->post_image.'', array('width' => '100%', 'style' => 'border: 1px solid #c0c0c0; padding: 5px'))?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('post-image', array('label' => 'Đổi hình ảnh', 'class' => 'form-control', 'type' => 'file'));?>
        </div>
        <div class="form-group">
            <select class="form-control" id="post-category-update" name="category_id_fkey">
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
        <?= $this->Form->input('Chỉnh sửa', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'edit-post'))?>
    </div>
    <?=$this->Form->end();?>
<!-- End Form -->
</div>
