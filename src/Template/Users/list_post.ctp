<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách bài viết</h2>
    <?= $this->Flash->render('delete-post');?>
    <!-- DataTable -->
    <div class="search-block">
        <?= $this->Form->create('search', ['id' => 'form-search', 'url' => ['controller' => 'Users', 'action' => 'listPost']]);?>
        <?= $this->Form->input('search', ['value' => $keySearch])?>
        <?= $this->Form->button('<i class="fa fa-search"></i>', ['class' => 'btn-search', 'escape' => false])?>
        <?= $this->Form->end()?>
    </div>
    <table class="table table-striped table-bordered table-hover " id="table-list-post">
        <thead>
            <tr align="center">
                <th style="width: 5%"><?= $this->Paginator->sort('id', $this->Html->image('sort_both.png'), ['escape' => false])?>ID</th>
                <th style="width: 45%"><?= $this->Paginator->sort('post_title', $this->Html->image('sort_both.png'), ['escape' => false])?>Tiêu để</th>
                <th style="width: 10%"><?= $this->Paginator->sort('Category.category_name', $this->Html->image('sort_both.png'), ['escape' => false])?>Chuyên mục</th>
                <th style="width: 10%"><?= $this->Paginator->sort('created_at', $this->Html->image('sort_both.png'), ['escape' => false])?>Ngày tạo</th>
                <th style="width: 8%"><?= $this->Paginator->sort('post_view', $this->Html->image('sort_both.png'), ['escape' => false])?>Views</th>
                <th>Ảnh đại diện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="append-html">
            <?php
            if (count($arrayPost) > 0) {
                foreach ($arrayPost as $keyPost => $itemPost) {
                    ?>
                    <tr>
                        <td><?= $itemPost->id ?></td>
                        <td><?= h($itemPost->post_title) ?></td>
                        <td><?= h($itemPost->category->category_name) ?></td>
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
                            <button class="btn btn-danger btn-sm btn-show-model" data-toggle="modal" data-target="#show-delete-post"><i class="fa fa-trash"></i> Xóa</button>
                        </td>
                    </tr>
                    <?php 
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Không có dữ liệu</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php if (count($arrayPost) > 0) { ?>
        <div class="pagination-block">
            <ul class="pagination-list">
                <?php 
                if (!empty($this->Paginator->numbers())) {
                    echo $this->Paginator->prev('<i class="fa fa-caret-left"></i>', ['escape' => false], null, ['class' => 'prev disabled']);
                }
                echo $this->Paginator->numbers();
                if (!empty($this->Paginator->numbers())) {
                    echo $this->Paginator->next('<i class="fa fa-caret-right"></i>', ['escape' => false], null, ['class' => 'next disabled']);
                }
                ?>
            </ul>
        </div>
    <?php }?>
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
                <?=$this->Form->create('', ['action' => 'deletePost']);?>
                <div class="form-group">
                    <?= $this->Form->input('post-id', ['type' => 'hidden', 'id' => 'post-id'])?>
                    <p>Bạn có chắc muốn xóa bài viết <strong id="post-name" style="font-weight: bold"></strong> ?</p>
                </div>
                <div class="form-group" style="text-align: right;">
                    <?= $this->Form->button(__('Đóng'), ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal'])?>
                    <?= $this->Form->button(__('Xóa'), ['class' => 'btn btn-danger', 'id' => 'post-delete', 'type' => 'submit'])?>
                </div>
                <?=$this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<!-- End modal delete -->
