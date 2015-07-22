git clone --recursive https://github.com/404mike/uguisu.git

git submodule foreach git pull origin master

Change nginx settings

Set sendfile to off in `/etc/nginx/nginx.conf` and restart nginx `service nginx restart`
