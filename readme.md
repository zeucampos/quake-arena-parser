### Configuração do projeto

Para iniciar, crie uma base de dados (MySql) com o nome que preferir.

Clone o projeto, acesse seu diretório e rode o comando:
``` shell
$ composer install
```


No diretório do projeto, crie um arquivo com o nome ".env" com o seguinte conteúdo:
```APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:gKBDiT0xH0brtZzUPY0GKTDmq+nuQIYenI0guRDqA9o=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=parser_db
DB_USERNAME=root
DB_PASSWORD=
```

Para __DB_DATABASE__ informe o nome do banco de dados criado.
Para __DB_USERNAME__ informe o nome de usuário para acesso ao banco.
Para __DB_PASSWORD__ informe a senha de acesso.

Em seguida inicie o servidor usando o comando do artisan:
``` shell
$ php artisan serve
```


A aplicação iniciará os serviços na porta 8000, caso não esteja sendo utilizada. Se isto acontecer, informe a porta que deseja utilizar da seguinte forma
``` shell
$ php artisan serve --port 8001
```

\
Ao acessar a aplicação __localhost:8000__ pela primeira vez ela irá popular o banco de dados com os logs de mortes, players e partidas de jogos.

