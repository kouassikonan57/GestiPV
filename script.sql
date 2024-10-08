create table migrations
(
    id        serial
        primary key,
    migration varchar(255) not null,
    batch     integer      not null
);

alter table migrations
    owner to postgres;

create table parcours
(
    id         bigserial
        primary key,
    nom        varchar(255) not null
        constraint parcours_nom_unique
            unique,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table parcours
    owner to postgres;

create table users
(
    id                bigserial
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null
        constraint users_email_unique
            unique,
    email_verified_at timestamp(0),
    password          varchar(255) not null,
    remember_token    varchar(100),
    created_at        timestamp(0),
    updated_at        timestamp(0)
);

alter table users
    owner to postgres;

create table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp(0)
);

alter table password_reset_tokens
    owner to postgres;

create table sessions
(
    id            varchar(255) not null
        primary key,
    user_id       bigint,
    ip_address    varchar(45),
    user_agent    text,
    payload       text         not null,
    last_activity integer      not null
);

alter table sessions
    owner to postgres;

create index sessions_user_id_index
    on sessions (user_id);

create index sessions_last_activity_index
    on sessions (last_activity);

create table cache
(
    key        varchar(255) not null
        primary key,
    value      text         not null,
    expiration integer      not null
);

alter table cache
    owner to postgres;

create table cache_locks
(
    key        varchar(255) not null
        primary key,
    owner      varchar(255) not null,
    expiration integer      not null
);

alter table cache_locks
    owner to postgres;

create table jobs
(
    id           bigserial
        primary key,
    queue        varchar(255) not null,
    payload      text         not null,
    attempts     smallint     not null,
    reserved_at  integer,
    available_at integer      not null,
    created_at   integer      not null
);

alter table jobs
    owner to postgres;

create index jobs_queue_index
    on jobs (queue);

create table job_batches
(
    id             varchar(255) not null
        primary key,
    name           varchar(255) not null,
    total_jobs     integer      not null,
    pending_jobs   integer      not null,
    failed_jobs    integer      not null,
    failed_job_ids text         not null,
    options        text,
    cancelled_at   integer,
    created_at     integer      not null,
    finished_at    integer
);

alter table job_batches
    owner to postgres;

create table failed_jobs
(
    id         bigserial
        primary key,
    uuid       varchar(255)                           not null
        constraint failed_jobs_uuid_unique
            unique,
    connection text                                   not null,
    queue      text                                   not null,
    payload    text                                   not null,
    exception  text                                   not null,
    failed_at  timestamp(0) default CURRENT_TIMESTAMP not null
);

alter table failed_jobs
    owner to postgres;

create table etudiants
(
    id             bigserial
        primary key
        constraint etudiants_id_foreign
            references users
            on delete cascade,
    nom            varchar(255) not null,
    prenom         varchar(255) not null,
    matricule      varchar(255) not null
        constraint etudiants_matricule_unique
            unique,
    date_naissance date         not null,
    lieu_naissance varchar(255) not null,
    niveau         varchar(255) not null
        constraint etudiants_niveau_check
            check ((niveau)::text = ANY
                   ((ARRAY ['LICENCE1'::character varying, 'LICENCE2'::character varying, 'LICENCE3'::character varying, 'MASTER1'::character varying, 'MASTER2'::character varying])::text[])),
    parcours_id    bigserial
        constraint etudiants_parcours_id_foreign
            references parcours
            on delete cascade,
    created_at     timestamp(0),
    updated_at     timestamp(0),
    user_id        bigint       not null
        constraint etudiants_user_id_foreign
            references users
            on delete cascade
);

alter table etudiants
    owner to postgres;

create table gestionnaires
(
    id         bigserial
        primary key
        constraint gestionnaires_id_foreign
            references users
            on delete cascade,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table gestionnaires
    owner to postgres;

create table reclamations
(
    id          bigserial
        primary key,
    libelle     varchar(255) not null,
    description text         not null,
    etudiant_id bigserial
        constraint reclamations_etudiant_id_foreign
            references etudiants
            on delete cascade,
    note_id     bigserial,
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table reclamations
    owner to postgres;

create table semestres
(
    id         bigserial
        primary key,
    libelle    varchar(255) not null,
    session    varchar(255) not null
        constraint semestres_session_check
            check ((session)::text = ANY ((ARRAY ['1'::character varying, '2'::character varying])::text[])),
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table semestres
    owner to postgres;

create table permissions
(
    id         bigserial
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0),
    constraint permissions_name_guard_name_unique
        unique (name, guard_name)
);

alter table permissions
    owner to postgres;

create table roles
(
    id         bigserial
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0),
    constraint roles_name_guard_name_unique
        unique (name, guard_name)
);

alter table roles
    owner to postgres;

create table model_has_permissions
(
    permission_id bigint       not null
        constraint model_has_permissions_permission_id_foreign
            references permissions
            on delete cascade,
    model_type    varchar(255) not null,
    model_id      bigint       not null,
    primary key (permission_id, model_id, model_type)
);

alter table model_has_permissions
    owner to postgres;

create index model_has_permissions_model_id_model_type_index
    on model_has_permissions (model_id, model_type);

create table model_has_roles
(
    role_id    bigint       not null
        constraint model_has_roles_role_id_foreign
            references roles
            on delete cascade,
    model_type varchar(255) not null,
    model_id   bigint       not null,
    primary key (role_id, model_id, model_type)
);

alter table model_has_roles
    owner to postgres;

create index model_has_roles_model_id_model_type_index
    on model_has_roles (model_id, model_type);

create table role_has_permissions
(
    permission_id bigint not null
        constraint role_has_permissions_permission_id_foreign
            references permissions
            on delete cascade,
    role_id       bigint not null
        constraint role_has_permissions_role_id_foreign
            references roles
            on delete cascade,
    primary key (permission_id, role_id)
);

alter table role_has_permissions
    owner to postgres;

create table ues
(
    id          bigserial
        primary key,
    code        varchar(255) not null
        constraint ues_code_unique
            unique,
    libelle     varchar(255) not null,
    type        varchar(255) not null
        constraint ues_type_check
            check ((type)::text = ANY ((ARRAY ['MAJEURES'::character varying, 'MINEURES'::character varying])::text[])),
    semestre_id bigint       not null
        constraint ues_semestre_id_foreign
            references semestres
            on delete cascade,
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table ues
    owner to postgres;

create table ecues
(
    id          bigserial
        primary key,
    libelle     varchar(255) not null,
    coefficient integer      not null,
    ue_id       bigint       not null
        constraint ecues_ue_id_foreign
            references ues
            on delete cascade,
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table ecues
    owner to postgres;

create table notes
(
    id          bigserial
        primary key,
    valeur      double precision not null,
    date        date             not null,
    etudiant_id bigint           not null
        constraint notes_etudiant_id_foreign
            references etudiants
            on delete cascade,
    ecue_id     bigint           not null
        constraint notes_ecue_id_foreign
            references ecues
            on delete cascade,
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table notes
    owner to postgres;

create table mentions
(
    id          bigserial
        primary key,
    etudiant_id bigint           not null
        constraint mentions_etudiant_id_foreign
            references etudiants
            on delete cascade,
    ue_id       bigint           not null
        constraint mentions_ue_id_foreign
            references ues
            on delete cascade,
    moyenne     double precision not null,
    mention     varchar(255)
        constraint mentions_mention_check
            check ((mention)::text = ANY
                   ((ARRAY ['INSUFFISANT'::character varying, 'PASSABLE'::character varying, 'ASSEZ BIEN'::character varying, 'BIEN'::character varying, 'TRES BIEN'::character varying, 'EXCELLENT'::character varying])::text[])),
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table mentions
    owner to postgres;

create table proces_verbals
(
    id          bigserial
        primary key,
    etudiant_id bigint        not null
        constraint proces_verbals_etudiant_id_foreign
            references etudiants
            on delete cascade,
    semestre_id bigint        not null
        constraint proces_verbals_semestre_id_foreign
            references semestres
            on delete cascade,
    moyenne     numeric(5, 2) not null,
    decision    varchar(255)  not null
        constraint proces_verbals_decision_check
            check ((decision)::text = ANY
                   ((ARRAY ['ADMIS'::character varying, 'AJOURNE'::character varying, 'REFUSE'::character varying])::text[])),
    created_at  timestamp(0),
    updated_at  timestamp(0)
);

alter table proces_verbals
    owner to postgres;


