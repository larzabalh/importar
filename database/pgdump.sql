create schema finance;

use finance;


CREATE TABLE tCountrys (
    idCountry integer NOT NULL auto_increment primary key ,
    countryName varchar(400) NOT NULL
);


CREATE TABLE tStates (
    idState integer NOT NULL auto_increment primary key,
    idCountry integer NOT NULL,
    stateName varchar(400) NOT NULL
);


CREATE TABLE migrations (
    id integer NOT NULL auto_increment primary key,
    migration varchar(400) NOT NULL,
    batch integer NOT NULL
);

CREATE TABLE password_resets (
    email varchar(400) NOT NULL,
    token varchar(400) NOT NULL,
    created_at datetime
);


CREATE TABLE tModules (
    idModule integer NOT NULL auto_increment primary key,
    nameModule varchar(400) NOT NULL,
    pathModule varchar(400) NOT NULL,
    idParent integer NOT NULL ,
    created_at datetime,
    updated_at datetime,
    classIcon varchar(400)
);


CREATE TABLE tUserModules (
    idUserModule integer NOT NULL auto_increment primary key,
    idUser integer NOT NULL ,
    idModule integer NOT NULL,
    created_at datetime,
    updated_at datetime
);



CREATE TABLE tUsers (
    idUser integer NOT NULL auto_increment primary key,
    loginUser varchar(400) NOT NULL,
    emailUser varchar(400) NOT NULL,
    password varchar(400) NOT NULL,
    statusUser integer DEFAULT 1 NOT NULL,
    remember_token varchar(400),
    created_at datetime,
    updated_at datetime,
    avatar varchar(400)
);
