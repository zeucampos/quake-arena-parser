Este projeto faz a leitura de um arquivo de logs do jogo Quake Arena e traduz de forma amigável e visual para saber quem pontuou mais e como se deu esta pontuação.

[Arquivo de logs](https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/045192ef9ff87ed87b36eda3170056485cfbdb5a/games.log)

##
### Configuração do projeto

Para iniciar, crie uma base de dados (MySql) com o nome **parser_db**.

Clone o projeto, acesse seu diretório e rode o comando:
``` shell
$ composer install
```


No diretório do projeto, crie um arquivo com o nome ".env" com o seguinte conteúdo:
``` text
APP_NAME=Laravel
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

__DB_USERNAME__: usuário do banco de dados.
__DB_PASSWORD__: senha do banco de dados.

Ainda no diretório do projeto, rode as migrations, assim criando as tabelas no banco de dados, usando o seguinte comando: 
``` shell
$ php artisan migrate
```

Em seguida inicie o servidor usando o comando do artisan:
``` shell
$ php artisan serve
```


A aplicação iniciará os serviços na porta 8000, caso não esteja sendo utilizada. Se isto acontecer, informe a porta que deseja utilizar da seguinte forma:
``` shell
$ php artisan serve --port 8001
```


Ao acessar a aplicação __localhost:8000__ pela primeira vez ela irá popular o banco de dados com os logs de mortes, players e partidas de jogos.

