#/bin/bash

echo "Iniciando o ambiente de desenvolvimento DOUG"

docker-compose up -d

echo "Instalando dependencias"

docker exec -it doug-app composer update

docker exec -it doug-app composer install

echo "Ambiente rodando"

docker ps -a