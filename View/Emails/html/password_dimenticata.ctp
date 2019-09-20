Utente <b><?php echo $user; ?></b>
<br />
<br />
Clicca sul seguente link per impostare una nuova password:
<br />
<br />
<a href="<?php echo HTTP_BASE.DS.APP_DIR.DS; ?>users/password_dimenticata?uid=<?php echo $userId; ?>&token=<?php echo $urlToken; ?>">RESET PASSWORD</a>
<br />
<br />
Il link fornito per il reset password ha una durata di 24 ore.
<br />
<i>Se non hai richiesto tu questo reset password, ignora questa mail.</i>
<br />
<br />
Best Regards