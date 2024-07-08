
FROM mysql:8.3.0

ENV MYSQL_DATABASE=processo_seletivo
ENV MYSQL_ROOT_PASSWORD=teste

COPY ./init.sql /docker-entrypoint-initdb.d/

COPY ./my.cnf /etc/my.cnf

RUN ["chmod", "644", "/etc/my.cnf"]
