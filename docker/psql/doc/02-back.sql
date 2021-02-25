drop table if exists back_user;
CREATE TABLE public.back_user (
	id serial NOT NULL,
	code uuid NOT NULL ,
	firstname varchar(50) NOT NULL,
	lastname varchar(50) NOT NULL,
	login varchar(50) NOT NULL,
	mail varchar(70) NOT NULL,
	"password" varchar(200) NULL DEFAULT NULL::character varying,
	active bool NOT NULL,
	phone varchar(15) NOT NULL,
	"token" varchar(300) NULL,
	img varchar(150) NULL,
	created_at timestamp NOT NULL,
	updated_at timestamp NULL,
	CONSTRAINT back_user_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_back_user ON back_user(code);

--------------------------------------------------------------------------------------------------------------------------

DROP TABLE IF EXISTS back_group;
CREATE TABLE public.back_group (
    id serial,
    code character varying(255) NOT NULL,
    label character varying(50) NOT NULL,
    roles varchar(300) NOT NULL,
	active boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE ONLY public.back_group
    ADD CONSTRAINT back_group_pkey PRIMARY KEY (id);

--------------------------------------------------------------------------------------------------------------------------

-- public.back_user_groups definition

-- Drop table

-- DROP TABLE public.back_user_groups;

drop table if exists back_user_groups;
CREATE TABLE public.back_user_groups (
	id serial NOT NULL,
	user_id int4 NOT NULL,
	group_id int4 NOT NULL,
	created_at timestamptz null,
	CONSTRAINT back_user_groups_pkey PRIMARY KEY (id),

  FOREIGN KEY (user_id) REFERENCES back_user (id) ON DELETE CASCADE,
  FOREIGN KEY (group_id) REFERENCES back_group (id) ON DELETE CASCADE
);

CREATE INDEX idx_back_user_group ON public.back_user_groups(id) ;

-- public.back_user_groups foreign keys

-- ALTER TABLE public.back_user_groups ADD CONSTRAINT back_user_groups_group_id_fkey null;
-- ALTER TABLE public.back_user_groups ADD CONSTRAINT back_user_groups_user_id_fkey null;

INSERT INTO public.back_group (code,"label",roles,created_at,updated_at,active) VALUES
	 ('ad61a317-61dd-4c31-bc81-959fda9e5b18','SUPER ADMIN','ROLE_SUPER_ADMIN','2020-06-08 09:57:43.258045+01','2020-07-03 15:35:16+01',true),
	 ('d93c97f8-eba6-4b87-8e23-539e5023278d','Admin','ROLE_ADMIN','2020-06-08 09:57:43.258045+01','2020-10-05 11:57:15+01',true);

INSERT INTO public.back_user (code,firstname,lastname,login,mail,"password",active,phone,"token",img,created_at,updated_at) VALUES
	 ('9ab78b57-08e2-4d94-856d-d79cb5b04d38','Flen','BEN FLEN','flen2','flen2@mail.com','accc9105df5383111407fd5b41255e23',true,'22555222',NULL,NULL,'2020-06-11 12:06:51+01','2020-06-12 07:20:53+01');
--------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
