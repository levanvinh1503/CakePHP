<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách chuyên mục</h2>
    <!-- Table Category -->
    <table class="table table-striped table-bordered table-hover" id="table-list-category">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên chuyên mục</th>
                <th>Đường dẫn</th>
                <th>Số bài viết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($arrayCategory as $keyCategory => $valueCategory) {
                ?>
                <tr>
                    <td><?= $valueCategory->id ?></td>
                    <td><?= $valueCategory->category_name ?></td>
                    <td><?= $valueCategory->category_slug ?></td>
                    <td><?= count($valueCategory->posts)?> bài viết</td>
                    <td>
                        <?= $this->Html->link('<i class="fa fa-edit"></i> Sửa', [
                            'controller' => 'Users',
                            'action' => 'editCategory',
                            'id' => $valueCategory->id
                        ], [
                            'class' => 'btn btn-primary edit-category',
                            'escape' => false
                        ])?>
                        <?= $this->Html->link('<i class="fa fa-trash"></i> Xóa', [
                            'controller' => 'Users',
                            'action' => 'editCategory',
                            'id' => $valueCategory->id
                        ], [
                            'class' => 'btn btn-danger btn-sm',
                            'escape' => false
                        ])?>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <!-- End table Category -->
</div>
<!-- End block list category -->
