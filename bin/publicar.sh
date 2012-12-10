#!/bin/bash

#IPS dos servidores.
IPS_PHP=("")
IPS_STC=("")

#Autenticação nos servidores.
USER=telesena

#Diretório de publicação.
WWW=/var/www/html/telesena

#Diretórios da aplicação com suas permissões.
DIRS_PHP=("application" "library" "log" "public_html" ".version")
PERM_PHP=("r" "r" "w" "r" "r")

DIRS_STC=("public_html" ".version")
PERM_STC=("r" "r")
#Diretórios da aplicação com suas permissões.

#Caminho da aplicação no disco.
APATH=`/usr/bin/dirname $0`/..

#Caminho para o diretório temporário.
TMP=/tmp

####################################################
# FAZ A PUBLICAÇÃO DO PHP VIA RSYNC
#
# RECOMENDA-SE O USO DE CHAVES DE AUTENTICAÇÃO
# PARA EVITAR O PROMPT DE SENHA A CADA CÓPIA.
#
# @param string $ip IP do servidor
# @return void
####################################################
function publicarPHP()
{
    x=0
    while [ $x != ${#DIRS_PHP[@]} ]
    do
        rsync -Cravzp --delete --chmod="a+${PERM_PHP[$x]}" $APATH/${DIRS_PHP[$x]} $USER@$1:$WWW
        let "x = x + 1"
    done
}

####################################################
# FAZ A PUBLICAÇÃO DO CONTEÚDO ESTÁTICO VIA RSYNC
#
# RECOMENDA-SE O USO DE CHAVES DE AUTENTICAÇÃO
# PARA EVITAR O PROMPT DE SENHA A CADA CÓPIA.
#
# @param string $ip IP do servidor
# @return void
####################################################
function publicarSTC()
{
    x=0
    while [ $x != ${#DIRS_STC[@]} ]
    do
        rsync -Cravzp --delete --chmod="a+${PERM_STC[$x]}" $APATH/${DIRS_STC[$x]} $USER@$1:$WWW
        let "x = x + 1"
    done
}

####################################################
# AJUSTA OS ARQUIVOS DE CONFIGURAÇÃO.
#
# @param string $ip IP do servidor
# @return void
####################################################
function config_altera()
{
    #Alterando arquivo ".htaccess".
    ORI=$APATH/public_html/.htaccess
    BKP=$TMP/ponto-htaccess
    cp -f $ORI $BKP
    OQUE="#SetEnv APPLICATION_ENV production"
    PQUE="SetEnv APPLICATION_ENV production"
    sed "s/$OQUE/$PQUE/g" $BKP > $ORI
    #Alterando arquivo ".htaccess".
    
    #Alterando arquivo "config.ini" da application "site".
    ORI=$APATH/application/site/config.ini
    BKP=$TMP/site-config.ini
    cp -f $ORI $BKP
    OQUE="201.20.8.139"
    sed "s/$OQUE/$1/g" $BKP > $ORI
    #Alterando arquivo "config.ini" da application "site".
    
    #Alterando arquivo "config.ini" da application "webservices".
    ORI=$APATH/application/webservices/config.ini
    BKP=$TMP/webservices-config.ini
    cp -f $ORI $BKP
    OQUE="201.20.8.139"
    sed "s/$OQUE/$1/g" $BKP > $ORI
    #Alterando arquivo "config.ini" da application "webservices".
}

####################################################
# RESTAURA OS ARQUIVOS DE CONFIGURAÇÃO.
#
# @param string $ip IP do servidor
# @return void
####################################################
function config_restaura()
{
    #Restaurando o arquivo ".htaccess".
    cp -f $TMP/ponto-htaccess $APATH/public_html/.htaccess
    rm -f $TMP/ponto-htaccess
    
    #Restaurando o arquivo "config.ini" da application "site".
    cp -f $TMP/site-config.ini $APATH/application/site/config.ini
    rm -f $TMP/site-config.ini

    #Restaurando o arquivo "config.ini" da application "webservices".
    cp -f $TMP/webservices-config.ini $APATH/application/webservices/config.ini
    rm -f $TMP/webservices-config.ini
}

####################################################
# LIMPA O CACHE DO SITE APÓS PUBLICADO.
#
# @param string $ip IP do servidor
# @return void
####################################################
function limpar_cache()
{
    cd $TMP
    rm -f $TMP/clear*
    wget "http://$1/cache/clear?user=admin&pass=apc"
    cd -
}

clear
#Executando publicação do PHP.
i=0
while [ $i != ${#IPS_PHP[@]} ]
do
    config_altera ${IPS_PHP[$i]}
    publicarPHP ${IPS_PHP[$i]}
    config_restaura
    limpar_cache ${IPS_PHP[$i]}
    let "i = i + 1"
done
#Executando publicação do PHP.

#Executando publicação do conteúdo estático(img,js,css...).
i=0
while [ $i != ${#IPS_STC[@]} ]
do
    config_altera ${IPS_STC[$i]}
    publicarSTC ${IPS_STC[$i]}
    config_restaura
    let "i = i + 1"
done
#Executando publicação do conteúdo estático(img,js,css...).

