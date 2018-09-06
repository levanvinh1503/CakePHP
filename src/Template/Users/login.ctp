<h2 class="title-login">Đăng nhập</h2>
<?= $this->Flash->render('login')?>
<?=$this->Form->create();?>
<div class="form-group">
<<<<<<< HEAD
    <?= $this->Form->input('username', array('label' => 'Tên đăng nhập', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->input('password', array('label' => 'Mật khẩu', 'class' => 'form-control'));?>
</div>
<div class="form-group">
    <?= $this->Form->button(__('Đăng nhập'), array('class' => 'btn btn-primary'))?>
    <?= $this->Html->link('Đăng ký', [
        'controller' => 'Users',
        'action' => 'register',
    ], [
        'escape' => false,
        'class' => 'btn btn-default'
    ])?>
=======
    <?= $this->Form->input('username', ['label' => 'Tên đăng nhập', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->input('password', ['label' => 'Mật khẩu', 'class' => 'form-control']);?>
</div>
<div class="form-group">
    <?= $this->Form->button(__('Đăng nhập'), ['class' => 'btn btn-primary'])?>
>>>>>>> af30548bdf92739aadf32ae7e0a85f7a361d4559
</div>
<?=$this->Form->end();?>
