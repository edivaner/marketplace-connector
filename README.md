## Motivo do projeto


## Instruções para iniciar o projeto.
    1. Para iniciar todos os serviços: 
``` docker-compose up -d --build ```

    2. Baixar as dependências do projeto dentro do container app (Dockerfile faz isso)
``` docker exec -it connector_app bash ```
 e 
``` composer install ``` 

    3. Copiar o .env  e gerar uma chave 
``` cp .env.example .env ```
    e  depois  
``` php artisan key:generate ``` 

    4. Rodar os migrates
``` php artisan migrate ```

    5. Sair de dentro do container
``` exit ```

    6. acessar localhost
``` http://localhost:3001/ ```
