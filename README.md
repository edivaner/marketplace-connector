## O que é este projeto
Este projeto importa informações de produto de um mock (com Mockoon) instanciado no docker e persiste as informações no banco de dados, e manda essas informações para um HUB, usando Laravel 11, Docker, Redis, filas e Design Patterns (State, Repository, Service).

## Baixar o projeto
```bash
git clone https://github.com/edivaner/marketplace-connector.git

cd marketplace-connector
```


## Configuração Inicial do Projeto - Para o Ambiente Local
### SO Ubuntu / terminal bash:
```bash
cp .env.example .env
```
### SO Windows (PowerShell):
```powershell
Copy-Item .env.example .env
```

## Informações sobre o banco de dados MYSQL
#### usar essar informações para criar o database. (Também disponiveis no .env)
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=connector_db
DB_USERNAME=connect_user
DB_PASSWORD=connect_password
```

## Instruções para iniciar o projeto.
Para iniciar todos os serviços: 

1. Instalando as dependências do PHP com o composer
```bash
composer install
```  

2. Subir os containers docker (serviços Laravel, MySql, Redis, Mockoon e 3 filas)
```bash
docker-compose up -d --build 
 ```

3. Gerar chave 
```bash 
docker exec -it connector_app php artisan key:generate
 ```

4. Rodar as migrations
```bash
docker exec -it connector_app php artisan migrate 
 ```

## Executando a importação de offers
### Este é o endpoint 
```
GET http://localhost:3001/api/import/offers
```

### Para executar no terminal

```bash
curl -X GET http://localhost:3001/api/import/offers
```
ou 
``` 
curl -i http://localhost:3001/api/import/offers
```

## Informações sobre as filas
### neste projeto existe 3 filas e todas são iniciados junto com o docker-compose
    - offers (offers-worker)
    - offer_details (details-worker)
    - default (default-worker)

#### Para ver os jobs sendo executado
Utiliza os comandos em terminais diferentes.
``` docker-compose logs -f offers-worker```
e
``` docker-compose logs -f detail-worker```

#### Para ver os logs da aplicação (Logs criados durante a execução)
```bash
docker exec -it connector_app tail -f storage/logs/laravel.log
```
