# superast

Sistema de CRM e gerenciamento de PBX integrado com Asterisk 11.

### Requisitos mínimos
* Asterisk 11 LTS (disponível em: http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-11-current.tar.gz)
* DAHDI (disponível em: http://downloads.asterisk.org/pub/telephony/dahdi-linux-complete/dahdi-linux-complete-current.tar.gz)
* LibPRI 1.4 (disponível em: http://downloads.asterisk.org/pub/telephony/libpri/libpri-1.4-current.tar.gz)
* Debian Squeeze 6.0.8 (disponível em: http://www.debian.org/releases/squeeze/debian-installer/)
* Linux Kernel Headers 2.6.32-5 para compilação do Asterisk, DAHDI e LIBPRI.

#### Instalando os Kernel Headers:
```bash
$ sudo apt-get install linux-headers-2.6.32-5-all
```

#### Compilando e Instalando DAHDI:
```bash
$ cd /usr/src
$ wget http://downloads.asterisk.org/pub/telephony/dahdi-linux-complete/dahdi-linux-complete-current.tar.gz
$ tar zxvf /usr/src/dahdi-linux-complete-current.tar.gz
$ cd /usr/src/dahdi-linux-complete*
$ make
$ make install
$ make config
```

#### Compilando e instalando LibPRI:
```bash
$ cd /usr/src
$ wget http://downloads.asterisk.org/pub/telephony/libpri/libpri-1.4-current.tar.gz
$ tar zxvf /usr/src/libpri-1.4-current.tar.gz
$ cd /usr/src/libpri-*
$ make
$ make install
```

#### Compilando e instalando Asterisk:
```bash
$ cd /usr/src
$ wget http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-11-current.tar.gz
$ tar zxvf /usr/src/asterisk-11-current.tar.gz
$ cd /usr/src/asterisk-11*
$ contrib/scripts/install_prereq install
$ ./configure
$ make menuselect # para selecionar os módulos adicionais
$ make
$ make install
$ make samples
$ make config
```





