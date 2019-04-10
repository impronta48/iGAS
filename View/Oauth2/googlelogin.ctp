<h1>Google Login funziona</h1>
<?php echo $u; ?>
<p>
<?php echo $this->Html->link(__('Home Page Login'), 'index' ); ?> 
</p>
<p>
    <?php if ($this->Session->check('Auth.User.id')) : ?>
    User id cake: <?php echo $this->Session->check('Auth.User.id');  ?> 
    <?php else: echo "Utente non loggato in cake"; endif;?>
    
</p>