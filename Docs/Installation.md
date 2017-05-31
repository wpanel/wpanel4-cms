# Installation

## Acquire the code
You can acquire the code from 3 ways:

1. Using composer;
2. Cloning the repository;
3. Downloading .zip/.tar.gz file;

### Using composer

`composer create-project "elieldepaula/wpanelcms" Blog`

This code will download a Wpanel copy into a Blog folder.

### Cloning the repository

`git clone https://github.com/elieldepaula/wpanel.git`

This code will clone all the repository in a wpanel folder.

### Downloading the .zip/.tar.gz file

In this way you can download the last release of the project into Github. This is the recommended way if you want to use a very tested and checked version of the code.

[download here](https://github.com/elieldepaula/wpanel/releases)

### Setup the easy way
The easiest way to run Wpanel is using the PHP embedded Web Server directly and the database SQLite3. After acquire the code, access the public folder and run PHP embedded server.

1. `cd /my/project/folder/public`
2. `php -S localhost:8000`
3. Access on your browser: http://localhost:8000

##### Using MySQL

If you want to use MySQL onn your project, follow these steps:

1. Create a new database on your server, leave him empty.
2. Insert the connection information in the file "**/public/config/database.php**"
3. Navigate to `cd /my/project/folder/public`
4. Run with `php -S localhost:8000`
5. Access on your browser: http://localhost:8000

You'll see the Setup page that is just a form to create the first user to Admin. Insert your email and a password to be redirected to the Admin login page.

After to perform your first login, check the link "View Website" on the top right to access the site. Or just open a new Tab on your browser and access again the localhost page.

### Setup on localhost
Loren ipsum dolor ...
### Setup on Xampp/Wampp
Loren ipsum dolor ...