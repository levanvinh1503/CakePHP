<div class="list-addpost-admin">
    <h2 class="title-dashborad">Thêm bài viết</h2>
    <?= $this->Flash->render('add-post'); ?>
    <!-- Form Edit Post -->
    <?= $this->Form->create('post', array('id' => 'form-edit-post', 'type' => 'file'));?>

    <div class="form-group">
        <?= $this->Form->input('post_title', array('label' => 'Tên bài viết', 'class' => 'form-control', 'id' => 'post-title', 'placeholder' => 'Nhập tên bài viết'));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post_slug', array('label' => 'Đường dẫn', 'class' => 'form-control', 'id' => 'post-slug', 'placeholder' => 'Đường dẫn bài viết (Tạo tự động)'));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post_description', array('label' => 'Mô tả ngắn', 'class' => 'form-control', 'placeholder' => 'Mô tả ngắn của bài viết'));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('Nội dung', array('type' => 'textarea', 'class' => 'ckeditor form-control', 'id' => 'post-content', 'name' => 'post_content'))?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('post_image', array('label' => 'Ảnh đại diện', 'class' => 'form-control', 'type' => 'file'));?>
    </div>
    <div class="form-group">
        <select class="form-control" id="post-category-add" name="category_id_fkey">
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
        <?= $this->Form->input('Thêm', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'add-post'))?>
    </div>
    <?=$this->Form->end();?>

    <!-- End Form -->
</div>
