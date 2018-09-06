<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách chuyên mục</h2>
    <?= $this->Flash->render('delete-category')?>
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
                        <?= $this->Html->link('<i class="fa fa-edit"></i> Sửa', array(
                            'controller' => 'Users',
                            'action' => 'editCategory',
                            'id' => $valueCategory->id
                        ), array(
                            'class' => 'btn btn-primary edit-category',
                            'escape' => false
                        ))?>
                        <button class="btn btn-danger btn-sm btn-show-model" data-toggle="modal" data-target="#show-delete-category"><i class="fa fa-trash"></i> Xóa</button>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <!-- End table Category -->
</div>
<!-- End block list category -->
<!-- Modal Delete-->
<div class="modal fade" id="show-delete-category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Xóa Chuyên Mục</h4>
            </div>
            <div class="modal-body">
                <?=$this->Form->create('', array('action' => 'deleteCategory'));?>
                <div class="form-group">
                    <?= $this->Form->input('category-id', array('type' => 'hidden', 'id' => 'category-id'))?>
                    <p>Bạn có chắc muốn xóa chuyên mục <strong id="category-name" style="font-weight: bold"></strong> cũng như các bài viết trong đó?</p>
                </div>
                <div class="form-group" style="text-align: right;">
                    <?= $this->Form->button(__('Đóng'), array('class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal'))?>
                    <?= $this->Form->button(__('Xóa'), array('class' => 'btn btn-danger', 'id' => 'category-delete', 'type' => 'submit'))?>
                </div>
                <?=$this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<!-- End modal delete -->
