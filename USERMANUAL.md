# GDM User Manual

If you do not want to read the very long README file,
here is what you have to do, in a nutshell:

1. get and unpack tarball from gitlab

2. provide your individual settings and files:

    - `about.html`
        should contain HTML formatted text, without the HTML header, just what is inside the <body>-Tag.

    - `.env.docker`
        fill in your database settings 

3. provide your data architecture and content, in SQL oder XML liquibase format:

    - `database/liquibase/changelog.xml`
    - `database/liquibase/changelogs/changelog-<n>.[sql|xml]`
    make sure you have a consistent DB structure, with fFreign keys as constraints.
    
    
4. build and deploy GDM
        
        docker build .
        docker run <ID>

5. run GDM

        http://172.17.0.2


