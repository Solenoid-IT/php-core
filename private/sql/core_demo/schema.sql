SET default_storage_engine = INNODB;

CREATE DATABASE `core_demo`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
;

USE `core_demo`;




CREATE TABLE `user`
(
    `id`                                 BIGINT UNSIGNED AUTO_INCREMENT                           NOT NULL,

    `username`                           VARCHAR(255)                                             NOT NULL,
    `password`                           VARCHAR(60)                                              NOT NULL,

    `name`                               VARCHAR(255)                                             NOT NULL,
    `surname`                            VARCHAR(255)                                             NOT NULL,

    `photo`                              BLOB                                                         NULL,

    `datetime.insert`                    TIMESTAMP                      DEFAULT CURRENT_TIMESTAMP NOT NULL,



    PRIMARY KEY (`id`),

    UNIQUE  KEY (`username`)
)
;

CREATE TABLE `visitor`
(
    `ip.address`                         VARCHAR(255)                                             NOT NULL,
    `ip.country.code`                    VARCHAR(255)                                             NOT NULL,
    `ip.country.name`                    VARCHAR(255)                                             NOT NULL,
    `ip.isp`                             VARCHAR(255)                                             NOT NULL,

    `user_agent`                         LONGTEXT                                                 NOT NULL,

    `browser`                            VARCHAR(255)                                             NOT NULL,
    `os`                                 VARCHAR(255)                                             NOT NULL,
    `hw`                                 VARCHAR(255)                                             NOT NULL,

    `datetime.insert`                    TIMESTAMP                      DEFAULT CURRENT_TIMESTAMP NOT NULL
)
;

CREATE TABLE `type_test`
(
    `integer`  BIGINT                                      NOT NULL,
    `decimal`  DECIMAL(7,3)                                NOT NULL,
    `string`   VARCHAR(255)                                NOT NULL,
    `bool`     BOOLEAN                                     NOT NULL,

    `datetime` TIMESTAMP                                   NOT NULL
)
;