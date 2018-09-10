<h2 class="title-login">Đăng ký</h2>
<?= $this->Flash->render('register') ?>
<?=$this->Form->create();?>
<div class="form-group">
    <?= $this->Form->input('username', ['label' => 'Tên đăng nhập', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('full_name', ['label' => 'Họ và tên', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('email', ['label' => 'Email', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('password', ['label' => 'Mật khẩu', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('re-password', ['label' => 'Xác nhận mật khẩu', 'class' => 'form-control', 'type' => 'password']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('phonenumber', ['label' => 'Số điện thoại', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('address', ['label' => 'Địa chỉ', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->button(__('Đăng ký'), ['class' => 'btn btn-primary'])?>
    <?= $this->Html->link('Trở về', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn btn-default'])?>
</div>
<?=$this->Form->end();?>
