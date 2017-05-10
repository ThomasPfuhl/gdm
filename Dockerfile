FROM php:7.0-apache

#add dotdeb repository:
RUN	echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list

#add dotdeb repository key:
RUN curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -

RUN apt-get update
RUN apt-get -y install libapache2-mod-php7.0 zip unzip

RUN curl -sL https://deb.nodesource.com/setup_7.x | bash -
RUN apt-get -y install nodejs

RUN  curl -L https://www.npmjs.com/install.sh | sh

RUN curl -sS https://getcomposer.org/installer | \
	php -- --install-dir=/usr/local/bin --filename=composer
	
#composer install  
ENV PMD_HOME /usr/share/app/
RUN mkdir $PMD_HOME -p && cd $PMD_HOME/ 
	
#composer install 
RUN	cd / && cd $PMD_HOME && \
	composer require doctrine/dbal && \ 
	composer require ignasbernotas/laravel-model-generator --dev && \
	#composer require stolz/laravel-schema-spy --dev  && \
	#composer require laravelcollective/html   && \
	composer update  

COPY .env $PMD_HOME/	
COPY gulpfile.js $PMD_HOME/	
COPY package.json $PMD_HOME/	
	
RUN cd $PMD_HOME && \

	npm install --save -g gulp-install && \
	npm install
	# npm install # && \
	# gulp

	
# COPY files.tar $PMD_HOME/
# ....
RUN tar -xvfz  $PMD_HOME/files.tar
	
	
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2

RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log

	RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

RUN ln -s $PMD_HOME/ /var/www/html
	
# VOLUME [ "/var/www/html" ]
WORKDIR /var/www/html

EXPOSE 80

ENTRYPOINT [ "/usr/sbin/apache2" ]
CMD ["-D", "FOREGROUND"]