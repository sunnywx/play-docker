 #!/usr/bin/env sh

set -ex

# run my php-82 full playground, already include psysh to test all php features
docker run -it --rm --name php8-env \
  -v ./play:/var/www/html \
  -v ./psysh_share:/usr/local/share/psysh \
  wx/php8-full-env:latest zsh