<div class="list-addcategory-admin">
    <h2 class="title-dashborad">Thêm chuyên mục</h2>
    <?= $this->Flash->render('add-category')?>
    <!-- Form add Category -->
    <?= $this->Form->create('', array('id' => 'form-add-category'));?>
    <div class="form-group">
        <?= $this->Form->input('category_name', array('label' => 'Tên chuyên mục', 'class' => 'form-control', 'placeholder' => 'Nhập tên chuyên mục'));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('category_slug', array('label' => 'Đường dẫn', 'class' => 'form-control', 'placeholder' => 'Đường dẫn chuyên mục (Tạo tự động)'));?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('Thêm', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'edit-post'));?>
    </div>
    <!-- End Form add Category -->
</div>
