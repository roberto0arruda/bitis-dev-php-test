# Projeto Bitis - Dev PHP

Projeto desenvolvido para conceito de avaliação pela [Bitis](https://www.bitis.com.br/).

Para esse projeto, as principias tecnologias utilizadas foram:

|         |Link                                             |
|---------|-------------------------------------------------|
|Docker   |<https://docs.docker.com/engine/install/ubuntu/> |
|PHP      |<https://php.net/>                               |
|Laravel  |<https://laravel.com/>                           |
|PHPUnit  |<https://phpunit.de/>                            |
|Postman  |<https://www.postman.com/>                       |

> Obs.: Tendo em vista que o projeto foi desenvolvido para executar em ambiente dockerizado, as instruções a seguir, levarão em consideração que, o [Docker](https://docs.docker.com/engine/install/ubuntu/) e [Docker Compose](https://docs.docker.com/compose/install/) já encontram-se devidamente instalados.
> Contudo, a utilização ou não do [Docker](https://docs.docker.com/engine/install/ubuntu/) fica a critério do testador da aplicação.

[Postman docs](https://documenter.getpostman.com/view/8093065/TVYAg16D)

## Docker

> Na raiz do projeto sera copiado o arquivo `.env.example` para o arquivo `.env`, que contém informações inerentes para a aplicação, por padrão a aplicação está acessível em `localhost:8000`, com um path `/api/nome_do_recurso`.

1. Iniciando ambiente do projeto
    > Com o terminal, navegue até a pasta raiz do projeto (`bitis-dev-php-test`) e execute o comando abaixo. Ao final do processo, deverá aparecer um `log` no terminal. Nesse ponto, a `api` já deve estar acessíveis em `localhost` na porta `8000`, caso as mesmas não tenham sido modificadas no arquivo `docker-compose.yml` da raiz projeto.

    ```bash
    docker-compose up -d
    ```

2. configs do projeto
    > Para continuar a config do projeto execute.

    ```bash
    docker-compose exec api bash
    ```

    > apos o passo anterior rode mais dois comando para copiar o env e instalar os pacotes que são:

    ```bash
    cp .env.example .env && composer install && php artisan key:generate
    ```

    > use este comando para rodar os testes automatizados:

    ```bash
    php artisan test
    ```

    > quando finalizar a instalação execute mais este comando abaixo e já poderá desfrutar da api desenvolvida.

    ```bash
    php artisan migrate
    ```

    > e se quiser pode rodar uma seed para alguns clientes.

    ```bash
    php artisan db:seed --class=CustomerSeeder
    ```

3. Derrubar os containers
    > Para finalizar os containers, basta executar no mesmo terminal `Ctrl + c`, por segurança, execute o comando abaixo.

    ```bash
    docker-compose down
    ```
