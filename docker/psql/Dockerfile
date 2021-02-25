FROM postgres
ENV POSTGRES_USER oussama 
ENV POSTGRES_PASSWORD educanet 
ENV POSTGRES_DB testdb 
COPY ./doc/01-init.sql /docker-entrypoint-initdb.d/
COPY ./doc/02-back.sql /docker-entrypoint-initdb.d/
COPY ./doc/03-quiz.sql /docker-entrypoint-initdb.d/
