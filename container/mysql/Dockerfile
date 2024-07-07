
FROM mysql:8

ENV MYSQL_DATABASE=processo_seletivo
ENV MYSQL_ROOT_PASSWORD=teste

COPY ./init.sql /docker-entrypoint-initdb.d/

COPY ./my.cnf /etc/my.cnf
