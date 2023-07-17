<p align="center">
    <img src="https://www.labellucie.com/wp-content/uploads/2021/08/logo_Skills4all.png" alt="Symfony Boilerplate" width="250" />
</p>
<h3 align="center">Skills4All Assessment</h3>

---

This is a simple car CRUD manager app, this can be use a boilerplate for new Symfony base applications

---

# Skills4All Assessment

> Replace this title and the following description with your project name and description.

A web application built with Symfony 6.3, twig, and doctrine.

## Setup

### Prerequisites

See all requirement here [Symfony 6](https://symfony.com/doc/6.0/setup.html) 
<br>
Also install [Symfony CLI](https://symfony.com/download)
#### DataBase server
* Serveur : Localhost via UNIX socket
* Type de serveur : MariaDB
* Version du serveur : 10.4.27-MariaDB - Distribution source
* Encryption : UTF-8 Unicode (utf8mb4)
#### web server
* Apache/2.4.54 (Unix) OpenSSL/1.1.1s PHP/8.2.0 mod_perl/2.0.12 Perl/v5.34.1
* Version du client de base de données : libmysql - mysqlnd 8.2.0
* Extension PHP : mysqli Documentation curl Documentation mbstring Documentation
* Version de PHP : 8.2.0

### First start

Copy the file [.env.dist](.env.dist) to a file named `.env`. For instance:

```
cp .env.dist .env
```

> Edit the [.env.dist](.env.dist) by updating the default values of `DATABASE_URL`.
> change the value of "db_user", "db_user_password" and "db_name" so tha it match you database credential

---
Next, run:

```
compose install
```

📣&nbsp;&nbsp;This command will install all dependency so that you can run the project.

Once the services have installed the dependencies, you can start the server:

```
symfony server:start
```

The home page is at 

> http://127.0.0.1:8000/
---
### Creenshot
<p align="center">
    <img src="https://raw.githubusercontent.com/ndouop/assessment/main/public/img/screen1.png" alt="Symfony Boilerplate" width="250" />
    <br />
    <img src="https://raw.githubusercontent.com/ndouop/assessment/main/public/img/screen2.png" alt="Symfony Boilerplate" width="250" />
</p>

### Run migration
Run the following commande for to migrate table to database
```
php bin/console doctrine:migrations:migrate
```
### Generate Fake data
If you want to generate fake data, you should run the following command and take the option that switch to your
```
php bin/console doctrine:fixtures:load
```

### Documentations

Make sure you have read the following documentations:
