# wp-development

WP development environment using Docker 🐳

## so how does this work?

To run a local version of Wordpress, we need to have `PHP` and `MySQL` running
on our local machine. Rather than globally installing these into our root OS, we
can run them in Docker containers, separate from the rest of our OS. We can spin
them up when we want to use them and spin them down when they are not required.

Rather than having an active installation of PHP on our machine at all times, we
can use a Docker container to serve up the PHP files for Wordpress just while we
need it, and remove it afterwards. In just the same way, we'll use a Docker
container to run a MySQL server instance just for this project, and we can spin
it down when we no longer need it. We'll also use a third container to run
PHPMyAdmin, which is a useful browser-based management tool for MySQL - we can
use this to import and export SQL files and get direct access to the Wordpress
database when we need it.

If you want to see how this is set up, you can take a look at the
[docker-compose.yml](./docker-compose.yml) file in this folder. This tells
Docker what containers to set up, on which ports, and how they should
communicate with each other and with the localhost.

### wtf is docker?

This
[introduction to docker-compose](https://hackernoon.com/practical-introduction-to-docker-compose-d34e79c4c2b6)
is quite useful.

There are tons of tutorials out there which can walk you through doing various
cool things with Docker. If you have some time, I would recommend trying
something useful like
[replacing your local Postgres installation with a Docker container](https://linuxhint.com/run_postgresql_docker_compose/)

## installation

You will need an up to date installation of
[Docker Desktop](https://www.docker.com/get-started) on your machine. Sign up
for a Docker account, and download the desktop software. It's a good idea to run
through some of the tutorials if you haven't used Docker before, but this
installation is intended to be easy to use even if you haven't.

- With this repo cloned to your local machine, navigate to this folder (cms)
- `npm install`

## getting started

### environment variables

You don't need to make any changes, but if you wish to set the ports that
Wordpress and/or PHPMyAdmin will be exposed on, you can edit the (.env)[./.env]
file in this folder

### on the command line

To spin up the containers:

- `docker-compose up -d` or `npm run dev:start`

To spin down the containers:

- `docker-compose down` or `npm run dev:stop`

To spin down the containers and remove the persistent database storage (this
will completely erase the database)

- `docker-compose down -v` or `npm run dev:erase`

### using wordpress

navigate to `localhost:8800` to see the Wordpress installation. The first time
you run Wordpress it will prompt you to select your language and begin a new
Wordpress site. You can start from here if you want to develop a new plugin or
theme.

The files for the wordpress installation are within the Docker container. We
don't need access to them, as we are going to write plugins or themes that can
be used in any installation of Wordpress. The `wp-content` folder in this
project is mapped to the same folder in the Docker container, so any files or
folders within this folder will overwrite the ones in this folder in the
Wordpress container. What this means is that we can add plugins, themes and
uploaded content to the relevant folders and they will be able to be used by the
PHP server running Wordpress on `localhost:8800`

To access the admin panel, navigate to `localhost:8800/wp-admin` and log in
using the username `admin` and password `abc123` (obviously we'll change these
to something much more secure when we set the CMS up online 😉). From this admin
area you can activate and deactivate plugins and change site settings.

#### importing a database

navigate to `localhost:8801` to access `PHPMyAdmin`

To replace the Wordpress database with an existing database, find the
`wordpress` database and drop all the existing tables within it. Then you can
use `import SQL` to import a SQL file with existing Wordpress data.

#### exporting a database

To export a SQL file (e.g to save your database or allow others to use the same
data) use `PHPMyAdmin` on `localhost:8802` to export a SQL file of the
`wordpress` database.

### plugins and themes in use for this CMS

[Mercury post types and editor blocks](./wp-content/plugins/mercury) - sets up
all custom post types, meta fields and Gutenberg editor blocks.

[REST files](./wp-content/plugins/REST-files) - exposes files as well as images
on the /media endpoint of the Wordpress REST API

[Headless theme](./wp-content/themes/headless) - removes all page rendering
capability from Wordpress as this will be done with Gatsby
