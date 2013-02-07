#!/bin/bash

DATE=$(date +%Y-%m-%d)
ROOT=$(dirname $0)/../data
ME=$(whoami)

# Limpando todo o conteúdo dos subdiretórios do diretório data.
for DIR in $(ls $ROOT)
do
	rm -Rf ${ROOT}/${DIR}/*
done
# Limpando todo o conteúdo dos subdiretórios do diretório data.
