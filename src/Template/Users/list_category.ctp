<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách chuyên mục</h2>
    <!-- DataTable -->
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
    <!-- End DataTable -->
</div>
<!-- End block list category -->
<!-- Modal Update-->
<div class="modal fade" id="show-update-category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Chỉnh Sửa Chuyên Mục</h4>
            </div>
            <div class="modal-body">
                <form id="form-update-category" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Tên chuyên mục</label>
                        <input type="hidden" name="category-id" id="category-id">
                        <input type="text" class="form-control" id="category-name" name="category-name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Đường dẫn</label>
                        <input type="text" class="form-control" id="category-slug" name="category-slug">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success" id="save-category">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End modal update -->
<!-- Modal Delete-->
<div class="modal fade" id="show-delete-category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xóa Chuyên Mục</h4>
            </div>
            <div class="modal-body">
                <form id="form-delete-category" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="category-id" id="category-id">
                    <p>Bạn có chắc muốn xóa chuyên mục <strong id="category-name"></strong> cũng như các bài viết trong đó?</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger" id="category-delete">Xóa</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
