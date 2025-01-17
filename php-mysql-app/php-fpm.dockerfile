FROM php:7.4-fpm
# FROM php:7.0.33-fpm-jessie

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    vim \
    procps \
    && rm -rf /var/lib/apt/lists/*

# Install mysqli, you can add more extensions
RUN docker-php-ext-install mysqli pdo_mysql

# Install xdebug
RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug

# Configure xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Create xdebug log file and set permissions
RUN touch /var/log/xdebug.log && chmod 666 /var/log/xdebug.log

# Configure php-fpm
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# install zsh, better move to first RUN
RUN apt-get update && apt-get install -y zsh \
    && rm -rf /var/lib/apt/lists/* \
    && sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended \
    && git clone --depth 1 https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions \
    && git clone --depth 1 https://github.com/zsh-users/zsh-syntax-highlighting.git ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-syntax-highlighting 

# Configure .zshrc
RUN sed -i 's/plugins=(git)/plugins=(git zsh-autosuggestions zsh-syntax-highlighting)/' ~/.zshrc && \
    sed -i 's/ZSH_THEME="robbyrussell"/ZSH_THEME="ys"/' ~/.zshrc && \
    echo '\n\
# Custom aliases\n\
alias ll="ls -la"\n\
alias ..="cd .."\n\
alias ...="cd ../.."\n\
alias gs="git status"\n\
alias gd="git diff"\n\
alias gco="git checkout"\n\
\n\
export PATH="$PATH:$HOME/.composer/vendor/bin:vendor/bin"\n\
' >> ~/.zshrc

RUN chsh -s /usr/bin/zsh root

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# install php-cs-fixer
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v3.phar -o php-cs-fixer \
    && chmod +x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer

# install psysh
RUN composer g require psy/psysh:@stable

WORKDIR /var/www/html
