<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách bài viết</h2>
    <!-- DataTable -->
    <table class="table table-striped table-bordered table-hover " id="table-list-post">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Tiêu để</th>
                <th>Chuyên mục</th>
                <th>Ngày tạo</th>
                <th>Views</th>
                <th>Ảnh đại diện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($arrayPost as $keyPost => $itemPost) {
                ?>
                <tr>
                    <td><?= $itemPost->id ?></td>
                    <td><?= $itemPost->post_title ?></td>
                    <td><?= $itemPost->category->category_name ?></td>
                    <td><?= $itemPost->created_at ?></td>
                    <td><?= $itemPost->post_view ?></td>
                    <td><?= $this->Html->image($itemPost->post_image, ['width' => '100px'])?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa fa-edit"></i> Sửa', [
                            'controller' => 'Users',
                            'action' => 'editPost',
                            'id' => $itemPost->id
                        ], [
                            'class' => 'btn btn-primary edit-category',
                            'escape' => false
                        ])?>
                        <?= $this->Html->link('<i class="fa fa-trash"></i> Xóa', [
                            'controller' => 'Users',
                            'action' => 'editPost',
                            'id' => $itemPost->id
                        ], [
                            'class' => 'btn btn-danger btn-sm',
                            'escape' => false
                        ])?>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <!-- End DataTable -->
</div>
