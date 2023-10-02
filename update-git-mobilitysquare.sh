#!/bin/bash
ssh massimoi@vps6.impronta48.it 'cd /var/www/vhosts/igas.mobilitysquare.eu/; git pull origin master; composer update'
