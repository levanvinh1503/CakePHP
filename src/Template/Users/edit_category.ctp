<div class="list-addcategory-admin">
    <h2 class="title-dashborad">Sửa chuyên mục</h2>
    <?= $this->Flash->render('edit-category');?>
    <!-- Form edit Category -->
    <?= $this->Form->create('', array('id' => 'form-add-category'));?>
    <div class="form-group">
        <?= $this->Form->input('category_name', array('label' => 'Tên chuyên mục', 'class' => 'form-control', 'value' => $editCategory->category_name));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('category_slug', array('label' => 'Đường dẫn', 'class' => 'form-control', 'value' => $editCategory->category_slug));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('Chỉnh sửa', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'edit-post'));?>
    </div>
    <!-- End Form edit Category -->
</div>
