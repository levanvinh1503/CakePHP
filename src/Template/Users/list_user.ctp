<div class="list-category-admin">
    <h2 class="title-dashborad">Danh sách người dùng</h2>
    <?= $this->Flash->render('import-file')?>
    <!-- Table Category -->
    <div class="search-block">
        <?= $this->Form->create('search', ['id' => 'form-search', 'url' => ['controller' => 'Users', 'action' => 'listUser']]);?>
        <?= $this->Form->input('mode', ['value' => 'search', 'class' => 'form-control', 'type' => 'hidden'])?>
        <?= $this->Form->input('search', ['value' => $keySearch])?>
        <?= $this->Form->button('<i class="fa fa-search"></i>', ['class' => 'btn-search', 'escape' => false])?>
        <?= $this->Form->end()?>
    </div>
    <div class="search-block">
        <?= $this->Form->create('import', ['id' => 'form-import', 'url' => ['controller' => 'Users', 'action' => 'listUser'], 'type' => 'file']);?>
        <?= $this->Form->input('mode', ['value' => 'import-file', 'class' => 'form-control', 'type' => 'hidden'])?>
        <?= $this->Form->input('', ['type' => 'file', 'class' => 'form-control', 'name' => 'import-file'])?>
        <?= $this->Form->button('<i class="fa fa-file-import"></i>', ['class' => 'btn-import', 'escape' => false])?>
        <?= $this->Form->end()?>
    </div>
    <div class="search-block">
        <?= $this->Form->create('import', ['id' => 'form-import', 'url' => ['controller' => 'Users', 'action' => 'exportFile']]);?>
        <?= $this->Form->button('<i class="fa fa-download"></i>', ['class' => 'btn-import', 'escape' => false])?>
        <?= $this->Form->end()?>
    </div>
    <table class="table table-striped table-bordered table-hover" id="table-list-users">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', $this->Html->image('sort_both.png'), ['escape' => false])?>ID</th>
                <th><?= $this->Paginator->sort('name', $this->Html->image('sort_both.png'), ['escape' => false])?>Name</th>
                <th><?= $this->Paginator->sort('email', $this->Html->image('sort_both.png'), ['escape' => false])?>Email</th>
                <th><?= $this->Paginator->sort('address', $this->Html->image('sort_both.png'), ['escape' => false])?>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (count($arrayUsers) > 0) {
                foreach ($arrayUsers as $keyUsers => $valueUsers) {
                    ?>
                    <tr>
                        <td><?= h($valueUsers->id) ?></td>
                        <td><?= h($valueUsers->name) ?></td>
                        <td><?= h($valueUsers->email) ?></td>
                        <td><?= trim($valueUsers->address)?></td>
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
    <?php if (count($arrayUsers) > 0) { ?>
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
    <!-- End table Category -->
</div>
<!-- End block list category -->
