
## Info

Ssh: vagrant@192.168.55.5 Password: vagrant

Backend host: api.wishlist.loc

Frontend host: wishlist.loc

**Mysql**:

Host: localhost 

Database: wishlist

User: wish Password: wish

User: root Password: root

**Project paths**:

Backend: `/var/www/backend`

Frontend: `/var/www/fronend`


## Deploy

Its very easy

Add to your hosts file

`sudo echo "192.168.55.5 api.wishlist.loc wishlist.loc" >> /etc/hosts`

`cd ./deploy`

`vagrant up`
