<h2 class="title-login">Đăng ký</h2>
<?= $this->Flash->render('register') ?>
<?=$this->Form->create();?>
<div class="form-group">
    <?= $this->Form->input('username', array('label' => 'Tên đăng nhập', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('full_name', array('label' => 'Họ và tên', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('email', array('label' => 'Email', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('password', array('label' => 'Mật khẩu', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('re-password', array('label' => 'Xác nhận mật khẩu', 'class' => 'form-control', 'type' => 'password'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('phonenumber', array('label' => 'Số điện thoại', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('address', array('label' => 'Địa chỉ', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->button(__('Đăng ký'), array('class' => 'btn btn-primary'))?>
    <?= $this->Html->link('Trở về', array('controller' => 'Users', 'action' => 'login'), array('class' => 'btn btn-default'))?>
</div>
<?=$this->Form->end();?>
