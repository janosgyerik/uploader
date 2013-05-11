Uploader
========
A single-page "site" for uploading files to a webserver using PHP.

This is really simplistic, for demonstration purposes, or when
you need this kind of functionality really quickly.


Setup
-----
1. Make the project directory visible on the webserver.
   For example you could symlink to it at a visible path,
   or copy the project to a visible path.

2. Create a sub-directory named `files` and make sure the
   webserver process can write inside this directory.

3. Add basic security by creating an `.htaccess` file:

        ./gen-htpasswd.sh testuser

