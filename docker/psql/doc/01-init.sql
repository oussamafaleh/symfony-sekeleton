/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  walid
 * Created: 6 juin 2020
 */
-- CREATE USER oussama WITH PASSWORD educanet;
-- CREATE DATABASE testdb;
-- GRANT ALL PRIVILEGES ON DATABASE testdb TO oussama;

-- drop table if exists api_user;

CREATE TABLE api_user (
	id serial NOT NULL,
	"name" varchar(50) NOT NULL,
	roles json NOT NULL,
	"token" varchar(180) NOT null ,
	CONSTRAINT api_user_pkey PRIMARY KEY (id)
);
CREATE UNIQUE INDEX uniq_ac64a0ba5f37a13b ON public.api_user USING btree (token);

-- Permissions

ALTER TABLE public.api_user OWNER TO oussama;
GRANT ALL ON TABLE public.api_user TO oussama;


INSERT INTO public.api_user
("name", roles , token)
VALUES( 'back', '{"BACK": "ROLE_BACK"}' ,'e74eb221af1245feaaffb4dd88081637' ),
('front', '{"FRONT": "ROLE_FRONT"}','e409219c8e64417089a2d4224db66745' ),
('mobile', '{"MOBILE": "ROLE_MOBILE"}','38f9a2cfdd364f23b0a4eb67e2e7b456');

-- VALUES( 'back', '{"BACK": "ROLE_BACK"}' ,'e74eb221af1245feaaffb4dd88081637' ),
-- ('front', '{"FRONT": "ROLE_FRONT"}','e409219c8e64417089a2d4224db66745' ),
-- ('mobile', '{"MOBILE": "ROLE_MOBILE"}','38f9a2cfdd364f23b0a4eb67e2e7b456');


DROP TABLE IF EXISTS wording_domain CASCADE;
CREATE TABLE IF NOT EXISTS wording_domain (
  id serial NOT NULL,
  code varchar(100) NOT NULL,
  label varchar(100) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ;

DROP TABLE IF EXISTS wording CASCADE;
CREATE TABLE IF NOT EXISTS wording (
  id serial  NOT NULL,
  code varchar(100) NOT NULL,
  label varchar(100) NOT NULL,
  domain_id int4  NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ;


--
-- Table structure for table wording_translation
--
DROP TABLE IF EXISTS wording_translation CASCADE;
CREATE TABLE wording_translation (
  id serial NOT NULL,
  wording_id int4 NOT NULL,
  content varchar(200) NOT NULL,
  language varchar(2) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ;

--
-- Constraints for table wording
--
ALTER TABLE wording
  ADD CONSTRAINT FK_wording_domain FOREIGN KEY (domain_id) REFERENCES wording_domain (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table wording_translation
--
ALTER TABLE wording_translation
  ADD CONSTRAINT fk_wording_translation_wording1 FOREIGN KEY (wording_id) REFERENCES wording (id) ON DELETE CASCADE ON UPDATE CASCADE;


INSERT INTO public.wording_domain ( code, label)
VALUES
( 'messages', 'messages'),
( 'errors', 'errors');



truncate table wording CASCADE; 
INSERT INTO public.wording ( code, label, domain_id)
VALUES
('error_occured', 'error occured', 2),
('empty_parameters', 'empty parameters', 2),
('invalid_token', 'invalid token', 2),
('forbidden_access', 'forbidden_access', 2),
('no_token', 'no token', 2),
('empty_token', 'empty token', 2),
('expired_session', 'expired session', 2),
('missing_verb', 'missing verb', 2),
('unknown_controller_action', 'unknown controller action', 2),
('unknown_parameter', 'unknown_parameter', 2),
('missing_parameters', 'missing_parameters', 2),
('missing_parameter', 'missing_parameter %parameter%', 2),
('invalid_parameter', 'invalid_parameter %parameter%', 2),
('invalid_format', 'invalid_format', 2),
('missing_parameters', 'missing_parameters', 2);
