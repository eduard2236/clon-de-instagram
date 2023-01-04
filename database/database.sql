CREATE DATABASE IF NOT EXISTS LARAVEL_MASTER;
USE LARAVEL_MASTER;

CREATE TABLE IF NOT EXISTS users(
    id              int(255) auto_increment not null,
    role            varchar(20),
    name            varchar(100),
    surname         varchar(200),
    nick            varchar(100),
    email           varchar(255),
    password        varchar(255),
    image           varchar(255),
    created_at      datetime,
    updated_at      datetime,
    remenber_token  varchar(255),
    constraint pk_user PRIMARY KEY(id)
)ENGINE=InnoDB;

insert into users values(null,'user','juan','lopes','lopes2236','lopes_0412@gmail.com','pass',null, CURTIME(),CURTIME(),null);
insert into users values(null,'user','roman','peres','peres2236','peres_0412@gmail.com','pass',null, CURTIME(),CURTIME(),null);

CREATE TABLE IF NOT EXISTS images(
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_path      varchar(255),
    description     TEXT,
    created_at      datetime,
    updated_at      datetime,
    constraint pk_images PRIMARY KEY(id),
    constraint fk_users  FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB;
insert into images values(null,1,'test.jpg','descricpcion de prueba 1',CURTIME(),CURTIME());
insert into images values(null,1,'hola.jpg','descricpcion de prueba 2',CURTIME(),CURTIME());
insert into images values(null,1,'chaval.jpg','descricpcion de prueba 3',CURTIME(),CURTIME());
insert into images values(null,3,'roman.jpg','descricpcion de prueba 4',CURTIME(),CURTIME());

CREATE TABLE IF NOT EXISTS  comments(
    id                  int(255) auto_increment not null,
    user_id             int(255),
    image_id            int(255),
    content             text,
    created_at          datetime,
    updated_at          datetime,
    constraint pk_comments PRIMARY KEY(id),
    constraint fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    constraint fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

insert into comments values(null,1,1,'que buena prueba',CURTIME(),CURTIME());
insert into comments values(null,1,4,'roman sube la foto bien',CURTIME(),CURTIME());
insert into comments values(null,3,2,'esta es la foto de bienvenida',CURTIME(),CURTIME());


CREATE TABLE IF NOT EXISTS  likes(
    id                  int(255) auto_increment not null,
    user_id             int(255),
    image_id            int(255),
    created_at          datetime,
    updated_at          datetime,
    constraint pk_likes PRIMARY KEY(id),
    constraint fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    constraint fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

insert into likes values(null,1,4,CURTIME(),CURTIME());
insert into likes values(null,1,3,CURTIME(),CURTIME());
insert into likes values(null,2,4,CURTIME(),CURTIME());
insert into likes values(null,3,2,CURTIME(),CURTIME());
insert into likes values(null,3,3,CURTIME(),CURTIME());

