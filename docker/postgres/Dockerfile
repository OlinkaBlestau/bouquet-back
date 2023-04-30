FROM postgres:latest



#RUN set -e && \
    #psql -U postgres -c "CREATE USER ${DB_USER} WITH SUPERUSER CREATEDB CREATEROLE ENCRYPTED PASSWORD '${DB_PASSWORD}';" && \
    #psql -U ${DB_USER} -d ${POSTGRES_DB} -c "CREATE DATABASE ${DB_NAME} TEMPLATE template0;"




#COPY init.sh /docker-entrypoint-initdb.d/10-init.sh
COPY init.sh /docker-entrypoint-initdb.d/init.sh

# pass variable PG_TABLE to users_init.sh to replace ${PG_TABLE} with .env variable in seed.sql
#RUN chmod +x ./users_init.sh
#COPY ./init.sh /
#RUN chmod +x /init.sh
#RUN /users_init.sh  \
#    DB_NAME "${DB_NAME}" \
#    DB_NAME_TEST "${DB_NAME_TEST}" \
#    DB_USER "${DB_USER}" \
#    DB_PASSWORD "${DB_PASSWORD}" \
#RUN sed -i "s/\${DB_NAME}/DB_NAME/g; s/\${DB_NAME_TEST}/DB_NAME_TEST/g; s/\${DB_USER}/DB_USER/g; s/\${DB_PASSWORD}/DB_PASSWORD/g" /init.sh