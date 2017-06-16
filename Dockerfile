FROM php:7.0-apache

#enable mod_rewrite
RUN a2enmod rewrite

#install pdo_mysql
RUN  \
  && echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
  && echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
  && apt-get update \
  && apt-get install -y apt-utils wget \
  && wget https://www.dotdeb.org/dotdeb.gpg \
  && apt-key add dotdeb.gpg \
  && apt-get install -y php7.0-mysql \
  && docker-php-ext-install pdo_mysql \
  && apt-get -y install libapache2-mod-php7.0 zip unzip nano


RUN curl -sL https://deb.nodesource.com/setup_7.x | bash -
RUN apt-get -y install nodejs

RUN echo prefix=~/.npm-packages >> ~/.npmrc && \
    curl -L https://www.npmjs.com/install.sh | sh && \
    export PATH="$HOME/.npm-packages/bin:$PATH"

RUN curl -sS https://getcomposer.org/installer | \
        php -- --install-dir=/usr/local/bin --filename=composer

#create home directory 
ENV GDM_HOME /usr/share/app/
RUN mkdir $GDM_HOME -p && cd $GDM_HOME/


#you will have to adapt the settings defined in .env
# rather provide a .env.docker in the distribution tarball
COPY .env.docker $GDM_HOME/.env

#install dependencies with composer
RUN     cd / && cd $GDM_HOME && \
        composer require doctrine/dbal && \
        composer require ignasbernotas/laravel-model-generator --dev
        #composer dump-autoload &&  \
        #composer install 
        #composer update 

# download release file
RUN cd $GDM_HOME && \
    curl -o gdm_latest.tgz https://code.naturkundemuseum.berlin/Thomas.Pfuhl/pmd/repository/archive.tar.gz?ref=master
RUN cd $GDM_HOME && \
    tar -xzf  $GDM_HOME/gdm_latest.tgz

# copy customized about-file
COPY about.html $GDM_HOME/public/appfiles/about.html

#RUN cd $GDM_HOME &&  composer update 
RUN cd $GDM_HOME &&  composer update --no-scripts
# cf. http://stackoverflow.com/questions/43769756/composer-install-doesnt-install-packages-when-running-in-dockerfile

# copy customized model generator files
COPY $GDM_HOME/lib/tools/MakeModelsCommand.php  $GDM_HOME/vendor/ignasbernotas/laravel-model-generator/src/Commands/MakeModelsCommand.php
COPY $GDM_HOME/lib/tools/model.stub  $GDM_HOME/vendor/ignasbernotas/laravel-model-generator/src/stubs/model.stub

RUN cd $GDM_HOME && \
    npm install --save -g gulp-install
RUN cd $GDM_HOME && \
    gulp


#make our own apache configuration      
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log

RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

COPY $GDM_HOME/lib/tools/000-default.conf /etc/apache2/sites-available/
WORKDIR $GDM_HOME/public
RUN chown -R www-data $GDM_HOME/
EXPOSE 80

ENTRYPOINT [ "/usr/sbin/apache2" ]
CMD ["-D", "FOREGROUND"]