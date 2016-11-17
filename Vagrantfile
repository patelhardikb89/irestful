# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "xenial-server-cloudimg-amd64-vagrant"
  config.vm.box_url = "https://cloud-images.ubuntu.com/xenial/current/xenial-server-cloudimg-amd64-vagrant.box"

  config.vm.network :private_network, ip: "192.168.66.60"
  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.synced_folder '.', '/vagrant', nfs: true

  config.vm.provider :virtualbox do |vb|
    vb.name = "irestful-rodson"
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--cpus", "8"]
    vb.customize ["modifyvm", :id, "--ostype", "Ubuntu_64"]
  end
  config.vm.provision "shell", inline: <<-shell

    DB_USERNAME="root";
    DB_PASSWORD=`tr -dc A-Za-z0-9 < /dev/urandom | head -c 8 | xargs`;
    DB_SERVER="127.0.0.1";
    DB_DRIVER="mysql";
    DB_NAME="just_roger";

    API_PROTOCOL="http";
    API_PORT="80";

    ENTITIES_API_URL="just-roger.entities.apis.irestful.dev";

    export LANGUAGE=en_US.UTF-8;
    export LANG=en_US.UTF-8;
    export LC_ALL=en_US.UTF-8;
    locale-gen en_US.UTF-8;
    dpkg-reconfigure locales;

    echo "export DB_USERNAME=$DB_USERNAME" >> /home/ubuntu/.profile;
    echo "export DB_PASSWORD=$DB_PASSWORD" >> /home/ubuntu/.profile;
    echo "export DB_SERVER=$DB_SERVER" >> /home/ubuntu/.profile;
    echo "export DB_DRIVER=$DB_DRIVER" >> /home/ubuntu/.profile;
    echo "export DB_NAME=$DB_NAME" >> /home/ubuntu/.profile;
    echo "export API_PROTOCOL=$API_PROTOCOL" >> /home/ubuntu/.profile;
    echo "export API_PORT=$API_PORT" >> /home/ubuntu/.profile;
    echo "export ENTITIES_API_URL=$ENTITIES_API_URL" >> /home/ubuntu/.profile;

    sudo apt-get update -y;
    sudo DEBIAN_FRONTEND=noninteractive apt-get -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" dist-upgrade;

    sudo apt-get install python-software-properties -y --force-yes;
    sudo apt-get install software-properties-common -y --force-yes;

    sudo apt-get install curl -y --force-yes;
    sudo apt-get install git -y --force-yes;
    sudo apt-get install sendmail -y --force-yes;

    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $DB_PASSWORD";
    sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $DB_PASSWORD";
    sudo apt-get install mysql-server php-mysql -y --force-yes;

    #update and upgrade
    sudo apt-get install php -y --force-yes;
    sudo apt-get install php-cli -y --force-yes;
    sudo apt-get install php-xdebug -y --force-yes;
    sudo apt-get install php-curl -y --force-yes;
    sudo apt-get install php-xml -y --force-yes;
    sudo apt-get install php-mbstring -y --force-yes;
    sudo apt-get install php-bcmath -y --force-yes;
    sudo apt-get install php-fpm -y --force-yes;
    sudo apt-get purge apache2 -y --force-yes;
    sudo apt-get autoremove -y --force-yes;
    sudo apt-get update -y;
    sudo apt-get upgrade -y;

    #install nginx
    sudo apt-get install nginx -y --force-yes;

    rm /etc/nginx/sites-available/default;
    rm /etc/nginx/sites-enabled/default;

    #https
    sudo cp /vagrant/src/iRESTful/LeoPaul/Objects/Libraries/Https/Tests/Configs/nginx/api.nginx.conf /etc/nginx/sites-available/api.https.nginx.conf;
    sudo ln -s /etc/nginx/sites-available/api.https.nginx.conf /etc/nginx/sites-enabled/api.https.nginx.conf;
    sudo cp /vagrant/src/iRESTful/LeoPaul/Objects/Libraries/Https/Tests/Configs/nginx/123.api.nginx.conf /etc/nginx/sites-available/123.api.nginx.conf;
    sudo ln -s /etc/nginx/sites-available/123.api.nginx.conf /etc/nginx/sites-enabled/123.api.nginx.conf;

    #entities
    sudo cp /vagrant/src/iRESTful/LeoPaul/Applications/APIs/Entities/Tests/Configs/nginx/api.nginx.conf /etc/nginx/sites-available/api.entities.nginx.conf;
    sudo ln -s /etc/nginx/sites-available/api.entities.nginx.conf /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{username}/$DB_USERNAME/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{password}/$DB_PASSWORD/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{server}/$DB_SERVER/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{driver}/$DB_DRIVER/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{api_protocol}/$API_PROTOCOL/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{api_url}/$ENTITIES_API_URL/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;
    sudo sed -i "s/{api_port}/$API_PORT/g" /etc/nginx/sites-enabled/api.entities.nginx.conf;

    #modify the www.conf file of php7.0-fpm:
    sudo cp /vagrant/src/iRESTful/LeoPaul/Applications/APIs/Entities/Tests/Configs/php7.0-fpm/www.conf /etc/php/7.0/fpm/pool.d/www.conf;
    sudo systemctl restart php7.0-fpm;
    sudo systemctl enable php7.0-fpm;
    sudo systemctl restart nginx;

    sudo service nginx restart;
    sudo echo "127.0.0.1 apis.https.irestful.dev" >> /etc/hosts;
    sudo echo "127.0.0.1 apis.entities.irestful.dev" >> /etc/hosts;

    #remove dependencies:
    sudo rm -R -f /vagrant/vendor;

    #delete/make the reports folder:
    sudo rm -R -f /vagrant/reports;
    mkdir /vagrant/reports;

    #download composer and install the dependencies:
    cd /vagrant; curl -sS https://getcomposer.org/installer | php;
    cd /vagrant; /vagrant/composer.phar install --prefer-source;

  shell
end
