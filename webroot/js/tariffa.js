function tar_regionale(min, tar)
{
	this.min= min;
	this.tar= tar;
}
			
//Tariffe Regionali in seconda Classe aggiornato al 9/1/2009
//tratto da http://www.regione.piemonte.it/trasporti/pendolari/tariffe/tariffe_trenitalia/tariffe.htm
function tariffa(km)
{
	var tt= new Array();
	
	tt[0]=new tar_regionale(5,1.1);
	tt[1]=new tar_regionale(10, 1.4);
	tt[2]=new tar_regionale (15, 1.7);
	tt[3]=new tar_regionale (20, 2);
	tt[4]=new tar_regionale (25, 2.2);
	tt[5]=new tar_regionale (30, 2.5);
	tt[6]=new tar_regionale (35, 2.7);
	tt[7]=new tar_regionale (40, 3.0);
	tt[8]=new tar_regionale (45, 3.3);
	tt[9]=new tar_regionale (50, 3.5);
	tt[10]=new tar_regionale (60, 3.9);
	tt[11]=new tar_regionale (70, 4.4);
	tt[12]=new tar_regionale (80, 4.8);
	tt[13]=new tar_regionale (90, 5.3);
	tt[14]=new tar_regionale (100, 5.7);
	tt[15]=new tar_regionale (125, 7.0);
	tt[16]=new tar_regionale (150, 8.3);
	tt[17]=new tar_regionale (175, 9.5);
	tt[18]=new tar_regionale (200, 10.8);
	tt[18]=new tar_regionale (225, 12.0);
	tt[19]=new tar_regionale (250, 13.2);

	if (km<=250)
	{
		for (i=0; i<=19; i++)
		{
			if (km <= tt[i].min)
				return tt[i].tar;
		}
	}
	return -1;
}
			