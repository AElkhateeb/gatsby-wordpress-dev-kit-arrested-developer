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
Wordpress and/or PHPMyAdmin will be exposed on, you can edit the [.env file in this folder](./.env)

### on the command line

To spin up the containers:

- `docker-compose up -d` or `npm run dev:start`

To spin down the containers:

- `docker-compose down` or `npm run dev:stop`

To spin down the containers and remove the persistent database storage (this
will completely erase the database)

- `docker-compose down -v` or `npm run dev:erase`

### using wordpress

navigate to `localhost:3000` to see the Wordpress installation. The first time
you run Wordpress it will prompt you to select your language and begin a new
Wordpress site. You can start from here if you want to develop a new plugin or
theme or just use an out-of-the-box Wordpress instance. USEFUL TIP: set your username
and password to something simple for your local installation to keep things simple
while you develop the site BUT obviously remember to change the password before you
deploy the Wordpress CMS online 😉.

The PHP, CSS and other files used by Wordpress installation are mostly all tucked away
within the Docker container. We don't need access to these as the only files we're interested
in are those that we can take away and pop into a brand new installation of Wordpress elsewhere - these files are the ones contained in the `wp-content` folder of Wordpress, mainly themes, plugins and uploaded files.

We're using a Docker feature called `mapping` to expose the wp-content folder on our local machine.
This overwrites the folder that exists within the Docker container with the folder on the local machine, meaning
any changes made in Docker are reflected in our local files and vice versa. What this means is that we
have easy access to the files that we need, and can ignore the rest.

To access the admin panel of Wordpress, navigate to `localhost:3000/wp-admin` and log in
using the username and password you chose when you set up Wordpress. From this admin
area you can activate and deactivate plugins and change site settings.

#### exporting / backing-up a database

If you're familiar with PHPMyAdmin, you might choose to use this to manage the MySql database. You can export, import and edit the database using the graphical interface if you want to. You can access PHPMyAdmin at localhost:3001

Using npm scripts you can run:

`npm run db:export`

This will save your entire wordpress database as a SQL file in ./backups with the current date as filename. Feel free to rename the file.

#### importing a database

You can also use PHPMyAdmin for this, or you can use the provided npm script.

Using npm scripts, you can import a database from the command line by running:

`IMPORT_DB=path_to_your_sql_file npm run db:import`

### included plugins and themes that you can use

[REST files](./wp-content/plugins/REST-files) - exposes files as well as images
on the /media endpoint of the Wordpress REST API. This tricks `gatsby-source-wordpress` into importing documents as well as images and pdf files at the build stage.

[Headless theme](./wp-content/themes/headless) - removes all page rendering
capability from Wordpress so you can use it as a headless CMS.

You can install plugins and themes from the Wordpress admin panel
