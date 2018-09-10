<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách chuyên mục</h2>
    <?= $this->Flash->render('delete-category')?>
    <!-- Table Category -->
    <div class="search-block">
        <?= $this->Form->create('search', array('id' => 'form-search', 'url' => array('controller' => 'Users', 'action' => 'listCategory')));?>
        <?= $this->Form->input('search', array('value' => $keySearch))?>
        <?= $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'btn-search', 'escape' => false))?>
        <?= $this->Form->end()?>
    </div>
    <table class="table table-striped table-bordered table-hover" id="table-list-category">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', $this->Html->image('sort_both.png'), array('escape' => false))?>ID</th>
                <th><?= $this->Paginator->sort('category_name', $this->Html->image('sort_both.png'), array('escape' => false))?>Tên chuyên mục</th>
                <th><?= $this->Paginator->sort('category_slug', $this->Html->image('sort_both.png'), array('escape' => false))?>Đường dẫn</th>
                <th>Số bài viết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (count($arrayCategory) > 0) {
                foreach ($arrayCategory as $keyCategory => $valueCategory) {
                    ?>
                    <tr>
                        <td><?= $valueCategory->id ?></td>
                        <td><?= h($valueCategory->category_name) ?></td>
                        <td><?= h($valueCategory->category_slug) ?></td>
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
    <?php if (count($arrayCategory) > 0) { ?>
        <div class="pagination-block">
            <ul class="pagination-list">
                <?php 
                if (!empty($this->Paginator->numbers())) {
                    echo $this->Paginator->prev('<i class="fa fa-caret-left"></i>', array('escape' => false), null, array('class' => 'prev disabled'));
                }
                echo $this->Paginator->numbers();
                if (!empty($this->Paginator->numbers())) {
                    echo $this->Paginator->next('<i class="fa fa-caret-right"></i>', array('escape' => false), null, array('class' => 'next disabled'));
                }
                ?>
            </ul>
        </div>
    <?php }?>
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
