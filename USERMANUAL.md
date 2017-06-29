# GDM User Manual

If you do not want to read the very very long README file,
here is what you have to do, in a nutshell:

1. get and unpack tarball from gitlab

2. provide your individual settings and files. Samples are located in folder `custom`:

    - `about.html`
        should contain HTML formatted text, without the HTML header, just what is inside the <body>-Tag.

    - `.env.example`
        fill in your database settings and your personal infos, especially GDM_SITE_NAME and GDM_SITE_MANAGER

    - `custom.css`, `.custom.js`
        fill in your customized layouts

    - `000-default.conf`
        these settings probably do not need any changes

3. provide your data architecture and content, in SQL oder XML liquibase format:

    - `database/liquibase/changelog.xml`
    - `database/liquibase/changelogs/changelog-<n>.[sql|xml]`
    make sure you have created a  brandnew empty database with the name GDM_SITE_NAME, defined in '.env.sample`,
   
4. build and deploy GDM
        
        docker build .
        docker run <ID>

5. run GDM

    point your browser to `http://172.17.0.2`

THIS IS THE END MY FRIEND.    
How many minutes did it take ?
