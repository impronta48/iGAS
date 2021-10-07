<?php
	$c = mysql_connect('localhost', 'max', 'clo-48tilde');
	$dbs = mysql_list_dbs();
	$igas_dbs=array();
	$exclude = array('igas_impronta');
	
	echo "Database su cui sarà applicato l'aggiornamento\n\r";		
	while ($row = mysql_fetch_assoc($dbs)) 
	{
		$db = $row['Database'];
	 
		
		if (stripos($db, 'igas_')!==FALSE && !in_array($db, $exclude))
		{
			$igas_dbs[] = $db;		//Estraggo i db di igas			
			echo "$db\n\r";		
		}
	}
	

	
	$qs = file_get_contents('update.sql');
	$qa = explode(';', $qs);
	echo "Query Applicate\n\r $qs\n\r";		
	
	
	foreach ($igas_dbs as $igas)
	{
		echo "$igas\n\r";	
		foreach ($qa as $q)
		{
			if (!empty($q))
			{
				$result = mysql_db_query($igas, $q);
				if (!$result) {
				   echo "DB Error, could not query the database\n";
				   echo 'MySQL Error: ' . mysql_error();
				}
			}
		}			
	}
	