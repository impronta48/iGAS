<ul>
    <li>
        <?php echo $this->Html->link(__('Login Facebook'), 'fbLogin' ); ?> 
    </li>
    <li>
        <?php echo $this->Html->link(__('Login Google'), 'googleLogin' ); ?> 
    </li>

</ul>

<p>
    <?php if ($this->Session->check('Auth.User.id')) : ?>
    User id cake: <?php echo $this->Session->check('Auth.User.id');  ?> 
    <?php else: echo "Utente non loggato in cake"; endif;?>
    
</p>