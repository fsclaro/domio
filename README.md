# Domio
## Objetivos

Este projeto foi criado para atender os requisitos da disciplina de Projeto Integrador II dos cursos do eixo da computação da Univesp (Universidade Virtual do Estado de São Paulo). Para tanto, foi desenvolvido um protótipo de sistema que permite a troca de mensagens entre moradores e o síndico de um determinado condomínio.

## Integrantes

* Aline Cristine Santos Dias
* Carlos Renan Monteiro
* Élder Alves Aquino Xavier
* Elton Guilherme Ribeiro Miranda
* Fernando Salles Claro
* Gabriel Braga Ribeiro
* Gabriel Monteiro de Oliveira
* João Rodrigues Parra

## Requisitos

* Banco de dados MySQL: ^8
* Framework Laravel: ^11
* Principais pacotes utilizados:
  * doctrine/dbal: ^4.0
  * leandrocfe/filament-apex-charts: ^3.1
  * malzariey/filament-daterangepicker-filter: ^2.6
  * pxlrbt/filament-excel: ^2.3
  * ariaieboy/filament-currency: ^1.4
* Principais pacotes dev:
  * arryvdh/laravel-ide-helper": ^3.0
  * larastan/larastan: ^2.9
  * lucascudo/laravel-pt-br-localization: ^2.2
  * squizlabs/php_codesniffer: ^3.9

## Testando o projeto antes de instalar

Caso você queira testar e conhecer o sistema, então acesse o link https://domio.joaoparra.dev. Ao acessar o sistema você pode utilizar uma das credenciais abaixo:

* Administrador: e-mail: admin@domio.test | senha: 12345678
* Gestor de Condomínio: e-mail: getor1@capytal.test | senha: 12345678

Você poderá também criar suas próprias credenciais, utilizando o link https://domio.joaoparra.dev/dashboard/register.

## Clonando o repositório

Para realizar a clonagem do repositório, você deve digitar o seguinte comando:

```bash
git clone git@github.com:fsclaro/domio.git

ou

git clone https://github.com/fsclaro/domio.git
```

## Pré-requisitos

Para que o projeto funcione adequadamente, você precisa instalar os seguintes programas

* Docker
* Composer

## Preparando o projeto

O projeto utilizará o pacote Sail do próprio Laravel para criar os containers necessários para que o mesmo entre em funcinamento.

Após a realização da clonagem do repositório, entre no diretório do projeto, digitando o comando:

```bash
cd domio
```

Copie o arquivo .env.example para .env utilizando o comando:

```bash
cp .env.example .env
```

Agora, precisamos ajustar alguns parâmetros dentro do arquivo .env. Edite o arquivo e altere os seguintes parâmetros para os valores indicados abaixo:

```env
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=domio
DB_USERNAME=root
DB_PASSWORD=
```

Agora execute os seguintes comandos:

```bash
php artisan key:generate
php artisan storage:link
chmod -R 755 storage
```

Vamos instalar os pacotes do projeto, digitando o seguinte comando:

```bash
composer install
```
**OBS:** Você perceberá que ocorrerão algumas mensagens de erro, não se assuste, vamos ajustar mais a frente. Estes erros exibidos estão relacionados ao banco de dados que ainda não existe.

Agora, vamos subir os containers do projeto. Execute o comando abaixo:

```bash
./vendor/bin/sail build
```
Para subir os containers do projeto, digite o seguinte comando:

```bash
./vendor/bin/sail up -d
```

Agora, vamos criar o banco de dados e inserir os registros básicos do sistema. Para tanto, execute o comando abaixo:

```bash
php artisan migrate --seed
```
Para acessar o sistema, abra o seu navegador e aponte para o endereço http://localhost

