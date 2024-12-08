
# Setup Docker Laravel 11 com PHP 8.3
[Assine a Academy, e Seja VIP!](https://academy.especializati.com.br)

### Passo a passo
Clone Repositório
```sh
git clone -b laravel-11-with-php-8.3 https://github.com/especializati/setup-docker-laravel.git app-laravel
```
```sh
cd app-laravel
```

Suba os containers do projeto
```sh
docker-compose up -d

parar os container
docker-compose down
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

OPCIONAL: Gere o banco SQLite (caso não use o banco MySQL)
```sh
touch database/database.sqlite
```

Rodar as migrations
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)

git hub
```sh
Instruções para acessar o github autenticado
[https://blog.formacao.dev/como-fazer-autenticacao-no-github-pelo-terminal/]

echo "# laravel11_docker" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin git@github.com:moacirx/laravel11_docker.git
git push -u origin main
```

'''sh
Instalação do Breeze

composer require laravel/breeze --dev

php artisan breeze:install
 
php artisan migrate
npm install
npm run dev

'''
