<h1>Login Facebook funziona</h1>
<p>
    <?php if ($this->Session->check('Auth.User.id')) : ?>
    User id cake: <?php echo $this->Session->check('Auth.User.id');  ?> 
    <?php else: echo "Utente non loggato in cake"; endif;?>
    
</p>
<p><?php echo $this->Html->link(__('Home Page Login'), 'index' ); ?> 
</p>
