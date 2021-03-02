drop table if exists demo;
CREATE TABLE public.demo (
	id serial NOT NULL,
	name varchar(50) NOT NULL,
        PRIMARY KEY (id)
);



INSERT INTO public.demo (name) VALUES
	 ('amel'),
	 ('oussama');

