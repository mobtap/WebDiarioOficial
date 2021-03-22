CREATE TABLE public.usuario
(
   id bigserial, 
   nome character(200), 
   email character(200), 
   usuario character(200), 
   senha character(200), 
   dep_codigo integer, 
   cpf character(100), 
   rg character(50), 
   orgao_expedidor character(50), 
   datanascimento character(30), 
   PRIMARY KEY (id)
) 
WITH (
  OIDS = FALSE
);
CREATE TABLE public.diario
(
  die_codigo bigint NOT NULL DEFAULT nextval('diario_die_codigo_seq'::regclass),
  die_arquivo character(200),
  die_arquivo_assinatura character(200),
  dep_codigo integer,
  die_conteudo text,
  tpo_codigo integer,
  die_datacadastro timestamp with time zone DEFAULT now(),
  die_dataatualizacao timestamp with time zone,
  edi_codigo integer,
  die_status boolean DEFAULT false,
  usu_id integer,
  CONSTRAINT diario_pkey PRIMARY KEY (die_codigo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.diario
  OWNER TO postgres;

CREATE TABLE public.edicao
(
  edi_codigo bigint NOT NULL DEFAULT nextval('edicao_edi_codigo_seq'::regclass),
  edi_nome character(200),
  edi_datacriacao timestamp with time zone DEFAULT now(),
  edi_dataatualizacao timestamp with time zone,
  edi_status boolean DEFAULT false,
  edi_datapublicacao timestamp with time zone,
  usu_id integer,
  CONSTRAINT edicao_pkey PRIMARY KEY (edi_codigo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.edicao
  OWNER TO postgres;

CREATE TABLE public.anexos_diario
(
  anx_codigo bigint NOT NULL DEFAULT nextval('anexos_diario_anx_codigo_seq'::regclass),
  anx_arquivo character(200),
  tpo_codigo integer,
  tpx_data timestamp with time zone DEFAULT now(),
  edi_codigo integer,
  usu_id integer,
  CONSTRAINT anexos_diario_pkey PRIMARY KEY (anx_codigo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.anexos_diario
  OWNER TO postgres;
