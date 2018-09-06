<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách bài viết</h2>
    <?= $this->Flash->render('delete-post');?>
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
                    <td><?= $this->Html->image($itemPost->post_image, array('width' => '100px'))?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa fa-edit"></i> Sửa', array(
                            'controller' => 'Users',
                            'action' => 'editPost',
                            'id' => $itemPost->id
                        ), array(
                            'class' => 'btn btn-primary edit-category',
                            'escape' => false
                        ))?>
                        <button class="btn btn-danger btn-sm btn-show-model" data-toggle="modal" data-target="#show-delete-post"><i class="fa fa-trash"></i> Xóa</button>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <!-- End DataTable -->
</div>
<!-- Modal Delete-->
<div class="modal fade" id="show-delete-post" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xóa Bài viết</h4>
            </div>
            <div class="modal-body">
                <?=$this->Form->create('', array('action' => 'deletePost'));?>
                <div class="form-group">
                    <?= $this->Form->input('post-id', array('type' => 'hidden', 'id' => 'post-id'))?>
                    <p>Bạn có chắc muốn xóa bài viết <strong id="post-name" style="font-weight: bold"></strong> ?</p>
                </div>
                <div class="form-group" style="text-align: right;">
                    <?= $this->Form->button(__('Đóng'), array('class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal'))?>
                    <?= $this->Form->button(__('Xóa'), array('class' => 'btn btn-danger', 'id' => 'post-delete', 'type' => 'submit'))?>
                </div>
                <?=$this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<!-- End modal delete -->
