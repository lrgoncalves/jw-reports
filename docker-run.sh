#/bin/bash

echo "Iniciando o ambiente de desenvolvimento "

docker-compose up -d

echo "Instalando dependencias"

docker exec -it jw-reports composer install

echo "Ambiente rodando"

docker ps -a