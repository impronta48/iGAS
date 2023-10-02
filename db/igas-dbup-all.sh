#!/bin/bash
#Aggiorna tutti gli igas lanciando dbup

cd db
array=( "alberto" "bikesquare" "demo" "impronta" "labins" "lindbergh" "yepp" "yepplanghe")
for i in "${array[@]}"
do
	./dbup.phar up --ini=".dbup/${i}.ini"
done
