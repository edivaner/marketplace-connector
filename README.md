## O que é este Projeto
Este projeto importa ofertas de um mock (Mockoon) e as persiste em banco, usando Laravel 11, Docker, Redis, filas e Design Patterns (State, Repository, Service).

## Baixar o projeto
```bash
git clone [adicionar url]

cd marketplace-connector
```


## Configuração Inicial do Projeto - Para o Ambiente Local
### SO Ubuntu:
```bash
cp .env.example .env
```
### SO Windows (PowerShell):
```powershell
Copy-Item .env.example .env
```

## Instruções para iniciar o projeto.
Para iniciar todos os serviços: 

    1. Subir os containers docker (serviços Laravel, MySql, Redis, Mockoon e 3 filas)
```bash
 docker-compose up -d --build 
 ```

    2. Instalando as dependências do PHP com o composer
```bash
docker exec -it connector_app composer install
```  

    3. Gerar chave 
```bash 
 docker exec -it connector_app php artisan key:generate --ansi 
 ```

    4. Rodar as migrations
```bash
 docker exec -it connector_app php artisan migrate 
 ```

## Informações dobre as filas
### Detalhei 3 filas e todas são iniciados junto com o docker-compose
    - offers (offers-worker)
    - offer_details (details-worker)
    - default (default-worker)


## Executando a importação de offers
### Este é o endpoint 
```
GET http://localhost:3001/api/import/offers
```

ou

```bash
curl -X GET http://localhost:3001/api/import/offers
```